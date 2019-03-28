<?php  if (count($checkUsers) > 0) : ?>
  <div class="checkUser">
  	<?php foreach ($checkUsers as $checkUser) : ?>
  	  <p><?php echo $checkUser ?></p>
  	<?php endforeach ?>
  </div>
<?php  endif ?>

<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Main Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="header">
	<h2>Home Page</h2>
</div>
<div class="content">
  	<?php if (isset($_SESSION['success'])) : ?>
      <div>
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <?php  if (isset($_SESSION['username'])) : ?>
    	<p>You have succesfully logged in <strong><?php echo $_SESSION['username']; ?></strong></p>
    	<p> <a href="checkUser.php?logout='1'" style="color: red;">logout</a> </p>
    <?php endif ?>
</div>
		
</body>
</html>