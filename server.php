<?php
 
// initializing variables
$username = "";
$email    = "";
$code="";
$errors = array();



  //expiration interval 5 mins
  date_default_timezone_set("Asia/Hong_Kong");
  $datetime = date("Y-m-d H:i:s");

  // Convert datetime to Unix timestamp
  $timestamp = strtotime($datetime);

  // Subtract time from datetime
  $time = $timestamp + (5 * 60);

  // Date and time after subtraction
  $newDateTime = date("Y-m-d H:i:s", $time);


// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'registration');

  // Generate captcha code


// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
 


  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  $pattern = "/[`'\"~!@# $*()<>,:;{}\|]/";
    if(strlen($password_1)!==8){
      array_push($errors, "Password Must be 8 Characters");
    }
    if(!preg_match("#[0-9]+#",$password_1)){
      array_push($errors, "Password Must Have number");
    }
    if(!preg_match("#[A-Z]+#",$password_1)){
      array_push($errors, "Password Must Have Capital Letter");
    }
     if(!preg_match($pattern,$password_1)){
      array_push($errors, "Password Must Have pattern");
    }
  
  if ($user) { 
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }


    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  
  if (count($errors) == 0) {
  	$password = md5($password_1);
    $_SESSION['email']=$email;
    $_SESSION['username'] = $username;

    $activity="Sign up";
    $query1 = "INSERT INTO activity_log (email, activity,d_time)VALUES('$email', '$activity','$newDateTime') ";
    $result = mysqli_query($db, $query1);

  	$query = "INSERT INTO users (username, email, password)VALUES('$username', '$email','$password')";
  	mysqli_query($db, $query);
    $_SESSION['success'] = "You are now Registered";
  	header('location: login.php ');
  }
}
// LOGIN USER

if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
  //verified // expired code
  $query = "SELECT * FROM users WHERE username='$username'";
  $results = mysqli_query($db, $query);
  $row = mysqli_fetch_assoc($results);
  $id= $row['id'];
  $verify= 0;

  if (count($errors) == 0) {
    $query = "SELECT * FROM users WHERE username='$username'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
      $_SESSION['username'] = $username;
    }else {
      array_push($errors, "Username Does not Exist");
      }
  }


 if (count($errors) == 0) {
   $password = md5($password);
   $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
   $results = mysqli_query($db, $query);
     
      if (mysqli_num_rows($results) == 1) {
       $_SESSION['password'] = $password;
       }else {
      array_push($errors, "Password is inconrrect");
      }
      
      if (mysqli_num_rows($results) == 1) {
             $xp11 = "SELECT expiration FROM authentication WHERE userid = $id";
              $xp2 = mysqli_query($db, $xp11);
                if(mysqli_num_rows($xp2) == 1) { 
                  $verify=1;
                  $_SESSION['email'];
                  $_SESSION['username'] = $username;
                 
                 $query= "SELECT * FROM users WHERE username='$username'";
                 $results = mysqli_query($db, $query);
                $row = mysqli_fetch_assoc($results);
              $email=$row['email'];
             $activity ="Log In";
             $query = "INSERT INTO activity_log (email, activity,d_time)VALUES('$email', '$activity','$newDateTime') ";
             $result = mysqli_query($db, $query);
                   header("location:index.php?username=$username");}
                   else{
                    header("location:code.php?username=$username");
                   }}
                    

 }
  else {
      array_push($errors, "username and Password do not match!");
    }
 


    //if verified
  if ($verify == 1) {

   //verified, check if code is expired
      $xp1 = "SELECT expiration FROM authentication WHERE userid = $id";
      $xp = mysqli_query($db, $xp1);
      $row = mysqli_fetch_assoc($xp);
      $expired= $row['expiration'];
          
              if ($datetime >= $expired) {
                      $delete = "DELETE FROM authentication WHERE userid = $id;";
                      mysqli_query($db, $delete);
                      header("location:code.php?username=$username");

  }
  else {
      array_push($errors, "Your Account Code is not Expired");}
     
    }





   
  }

  
if(isset($_POST['authenticate'])) {
  $activity = "Account authenticate";
  $code1=mysqli_real_escape_string($db, $_POST['c_code']);
  $code2=mysqli_real_escape_string($db, $_POST['codes']);
  $username = mysqli_real_escape_string($db, $_POST['uname']);
  $time = $_POST['time'];

   $query= "SELECT * FROM users WHERE username='$username'";
    $results = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($results);
    $id= $row['id'];
    $email= $row['email'];
  if (count($errors) == 0) {
       $query = "INSERT INTO activity_log (email, activity,d_time)VALUES('$email', '$activity','$newDateTime') ";
       $result = mysqli_query($db, $query);
   if($code1 == $code2){
       $codes= $_POST['c_code']; 
      $query = "INSERT INTO  authentication (userid,code,expiration) values('$id','$codes','$newDateTime')";
      mysqli_query($db, $query);
      $_SESSION['email'];
      $_SESSION['username'] = $username;
      $_SESSION['success'] = "You are now verified";
       header("location:index.php?username=$username");
      }}
      else{
        header('location:login.php');
        
      }
  
    }
    
   


   


  
if(isset($_POST['reset'])) {
  $email = mysqli_real_escape_string($db, $_POST['email']);

  $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user['email'] !== $email) {
      array_push($errors, "wrong email");
    }else{
    $_SESSION['email'];
    header("location:update.php?email=$email");
}}

if(isset($_POST['save'])) {
  $activity="Change Password";
  $pattern = "/[`'\"~!@# $*()<>,:;{}\|]/";
  $email=mysqli_real_escape_string($db, $_POST['emails']);
  $old_pass=mysqli_real_escape_string($db, $_POST['old_pass']);
  $new_pass = mysqli_real_escape_string($db, $_POST['new_pass']);

  

  $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
  $results = mysqli_query($db, $user_check_query);
  $row = mysqli_fetch_assoc($results);

    if(strlen($new_pass)!==8){
      array_push($errors, "Password Must be 8 Characters");
    }
    if(!preg_match("#[0-9]+#",$new_pass)){
      array_push($errors, "Password Must Have number");
    }
    if(!preg_match("#[A-Z]+#",$new_pass)){
      array_push($errors, "Password Must Have Capital Letter");
    }
     if(!preg_match($pattern,$new_pass)){
      array_push($errors, "Password Must Have pattern");
    }
    if (count($errors) == 0) {
       $query = "INSERT INTO activity_log (email, activity,d_time)VALUES('$email', '$activity','$newDateTime') ";
       $result = mysqli_query($db, $query);
     




   if (mysqli_num_rows($results) == 1) {
    $password=  md5($new_pass);
    $_SESSION['username'] = $username;
    $query = "UPDATE users set password='$password' WHERE email='$email ";
    header("location:login.php");
     
    }
    }else {
           array_push($errors, "Password Must Have pattern");

}
  }



?>
