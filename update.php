<?php
session_start();
 include('server.php'); 

 $email1 = $_GET['email'];

?>
<!DOCTYPE html>
<html>
<head>
	<title>Update Password</title>
  <link  rel="stylesheet" type="text/css" href="css.css">
</head>
<body>
  <div class="header">
    <h2>Update Password</h2>
  </div>
	<form method="post">
		<?php include('errors.php'); ?>
      <div class="input-group">
		<label>Email</label>
  		<input type="text" name="emails" value="<?php echo @$email1; ?>" readonly>
  		</div>
        <div class="input-group">
      <label>Old Password</label>
  		<input type="password" name="old_pass" required>
  		 </div> <div class="input-group">
      <label>New Password</label>
  		<input type="password" name="new_pass" required>
  		<button type="submit" class="btn" name="save">Save</button>
</div>


</body>
</html>