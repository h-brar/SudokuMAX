<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Assignment3</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Sign Up!</h2>
  </div>
	
  <form method="post" action="signup.php">
  	
  	<div class="userInfo">
  	  <label>Username</label>
  	  <input type="text" name="username" value="<?php echo $username; ?>">
  	</div>
  	<div class="userInfo">
  	  <label>Password</label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="userInfo">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2">
  	</div>
  	<div class="userInfo">
  	  <button type="submit" class="btn" name="reg_user">Sign up</button>
  	</div>
  </form>
      <p>
      login or sign up? <a href="login.php">login!</a>
    </p>
</body>
</html>