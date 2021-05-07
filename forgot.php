<?php
 include('server.php'); 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Forgot Password</title>
	<link  rel="stylesheet" type="text/css" href="css.css">
</head>
<body>
	 <div class="header">
  	<h2>Forgot Password?</h2>
  </div>
	<form method="post">

		<?php include('errors.php'); ?>
		 	<div class="input-group">
		<label>Email</label>
  		<input type="text" name="email" required>
  		<button type="submit" class="btn" name="reset">Reset</button>
</div>


</body>
</html>