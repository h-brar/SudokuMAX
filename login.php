<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Login to SudokuMax</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>


<p id="title" font-size="20px">SudokuMax</p>

<form action="login.php" method="post">



<div class="userInfo">
	Please enter your username: <br><input type="text"     name="user"><br>
</div>
<div class="userInfo">
	Please enter your password: <br><input type="password" name="pass"><br>
</div>
<input type="submit" value="Submit">
</form><br>
<p>Not yet registerd? <a href="signup.php">Sign Up!</a> 

</body>
</html>