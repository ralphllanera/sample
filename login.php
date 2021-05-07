<?php
session_start();
 include('server.php');
 
?>

<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link  rel="stylesheet" type="text/css" href="css.css">
</head>
<body>
  <div class="header">
  	<h2>Login</h2>
  </div>
	 
  <form method="POST" >
       <?php include('errors.php'); ?>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="username" required>
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password" required>
  	</div>
    
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>

    <p>
       <a href="forgot.php">Forgot Password?</a>
    </p>

  	<p>
  		Want to Register? <a href="register.php">Sign up</a>
  	</p>
  </form>
</body>
</html>