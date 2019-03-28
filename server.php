
<?php
session_start();

$username = "";
$checkUser = array(); 

$db = mysqli_connect('localhost', 'root', 'midnight7', 'sudokumax'); // replace midnight7 with your database pswd


// Sign up
if (isset($_POST['signup_user'])) {

  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  if (empty($username)) { array_push($checkUser, "Username is required"); }
  if (empty($password_1)) { array_push($checkUser, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($checkUser, "passwords do not match");
  }

  $user_check_query = "SELECT * FROM users WHERE username='$username'  LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) 
  {
    if ($user['username'] === $username) {
      array_push($checkUser, "Username already exists");
    }

  }

  if ($checkUser == 0) {
  	$password = md5($password_1);

  	$query = "INSERT INTO users (username, password) VALUES('$username', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: checkUser.php');
  }
}
// LOGIN 
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
    array_push($checkUser, "Username is required");
  }
  if (empty($password)) {
    array_push($checkUser, "Password is required");
  }

  if ($checkUser == 0) {
    $password = md5($password);
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
      $_SESSION['username'] = $username;
      $_SESSION['success'] = "You are now logged in";
    }else {
      array_push($checkUser, "Wrong username/password combination");
    }
  }
}

?>