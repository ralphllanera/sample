<?php
session_start();
  include('server.php'); 


  //$random_num    = md5(random_bytes(64));
 // $code  = substr($random_num, 0, 8);
 $code= rand(1, 1000000);

 
$username = $_GET['username'];

//echo $secs;

?>
<!DOCTYPE html>

<html>
<head>
	<title></title>
		<link  rel="stylesheet" type="text/css" href="css.css">
</head>
<body>
	<form method="post" >
    <?php include('errors.php'); ?>

     <div class="input-group">
            <label>Username</label>
            <input type="label" name="uname" value="<?php echo @$username; ?>" readonly>
       </div>
      <div class="input-group">
            <label>Enter Authentication Code</label>
            <input type="text" name="c_code" placeholder="Enter The Code" required >
       </div>
       <div class="input-group">     
           
            <input type="text" name="codes" value="<?php echo @$code; ?>" readonly></input>
             
             
             <button type="submit" name="authenticate" class="btn">Submit</button>
      </div>
     

  </form>

</body>
</html>
