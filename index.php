 <?php
     session_start();


     ?>
<!DOCTYPE html>
<html>
<head>
  <title>Home</title>
  <link  rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
   <div class="header">
    <h2>Home Page</h2>
  </div>
<form method="post">
<center><h3>Activity Log</h3></center>
    <table class="content-table" style="border-collapse: collapse; margin: 25px 0; font-size: 0.9em; min-width: 400px;">
      <tr>
      <th style="background-color: #C0C9CD;
  color: black;
  text-align: center;
  font-weight: bold;">Id</th>
      <th style="background-color: #C0C9CD;
  color: black;
  text-align: center;
  font-weight: bold;">Email</th>
      <th style="background-color:#C0C9CD ;
  color: black;
  text-align: center;
  font-weight: bold;">Activity</th>
      <th style="background-color:#C0C9CD ;
  color: black;
  text-align: center;
  font-weight: bold;">Date & Time</th>
      </tr>
    <?php

        include('server.php');

        error_reporting(0);
            $username = $_GET['username'];

            $query1 ="SELECT * FROM users WHERE username='$username'";
            $results = mysqli_query($db, $query1);
            $row = mysqli_fetch_assoc($results);
            $email= $row['email'];

            $query ="SELECT * FROM activity_log WHERE email='$email'";
            $data =mysqli_query($db,$query);
            $total =mysqli_num_rows($data);

            if($total!=0){
            while($result=mysqli_fetch_assoc($data)){
            echo "<tr><td>".$result['id']."</td><td>".$result['email']." </td><td>".$result['activity']."</td><td>".$result['d_time']."</td></tr>";
        }
    }
          else{
            echo "cannont find the data!";
          }
?>
  
   </table>
   <label name="uname" value="<?php echo @$email; ?>"></label>
   <button type="submit" class="btn" name="exit">Logout</button>
   <?php
       if(isset($_POST['exit'])) {
     
      $_SESSION['username']=$username;
      $query= "SELECT * FROM users WHERE username='$username'";
      $results = mysqli_query($db, $query);
      $row = mysqli_fetch_assoc($results);
      $email=$row['email'];
      $activity ="Logout";
       $query = "INSERT INTO activity_log (email, activity,d_time)VALUES('$email', '$activity','$newDateTime') ";
      $result = mysqli_query($db, $query);
      header("location:login.php");
    
}
   ?>
   </form>
   </body>
   </html>


