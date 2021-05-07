<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="css.css">
</head>
<body>
  <div class="header">
  	<h2>Sign Up</h2>
  </div>
	
  <form method="post" action="register.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  	  <label>Username</label>
  	  <input type="text" required name="username" >
  	</div>
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" required>
  	</div>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="text" name="password_1" required>
  	</div>
  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="text" name="password_2" required>
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user" >Register</button>
  	</div>
  	<p>
  		Already have a Acoount? <a href="login.php">Sign in</a>
  	</p>
  </form>
</body>
</html>