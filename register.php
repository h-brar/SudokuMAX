
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'includes/db.php';

    $replymsg = '<div class="alert alert-danger" role="alert"><strong>Error!</strong> Undefined error!</div>';

    $username = $_POST['inputUsername'];
    $email = $_POST['inputEmail'];
    $password = $_POST['inputPassword'];
    $cPassword = $_POST['inputCPassword'];

    $sql = "SELECT id FROM users WHERE username = '$username'";
    $result = mysqli_query($connection,$sql);

    if ($captcha_success->success==false) {
        $replymsg = '<div class="alert alert-danger" role="alert"><strong>Error!</strong> Invalid captcha!</div>';
    }
    else if(mysqli_num_rows($result) >= 1) {
        $replymsg = '<div class="alert alert-danger" role="alert"><strong>Error!</strong> Username already exists!</div>';
    }
    else if($password != $cPassword) {
        $replymsg = '<div class="alert alert-danger" role="alert"><strong>Error!</strong> Both passwords do not match!</div>';
    }
    else if ($captcha_success->success==true) {
        $sql = "INSERT INTO users (username,password,email,created) VALUES ('{$connection->real_escape_string($username)}',
        '{$connection->real_escape_string(password_hash($password, PASSWORD_DEFAULT))}',
        '{$connection->real_escape_string($email)}',
        '{$connection->real_escape_string(date("Y-m-d H:i:s"))}' )";
        $insert = $connection->query($sql);

        if ($insert == TRUE) {
            $_SESSION['user_id'] = $username;
            $replymsg = '<div class="alert alert-success" role="alert"><strong>Success!</strong> <a href="dashboard.php">Click here</a> to view the dashboard!</div>';
        }
        else {
            die("Error: {$connection->errno} : {$connection->error}");
        }
    }
$connection->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SudokuMAX - Register</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/heroic-features.css" rel="stylesheet">
    <link href="css/register.css" rel="stylesheet">

    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/">SudokuMAX</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <?php
                if ( isset( $_SESSION['user_id'] ) ) {
                    echo '
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    ';
                }
                else {
                    echo '
                    <li class="nav-item">
                        <a class="nav-link active" href="register.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    ';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card-signin my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">Register</h5>
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        echo $replymsg;
                    }
                    ?>
                    <form class="form-signin" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
                        <div class="form-label-group">
                            <input type="text" name="inputUsername" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
                            <label for="inputUsername">Username</label>
                        </div>

                        <div class="form-label-group">
                            <input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="Email address" required>
                            <label for="inputEmail">Email address</label>
                        </div>

                        <hr>

                        <div class="form-label-group">
                            <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required>
                            <label for="inputPassword">Password</label>
                        </div>

                        <div class="form-label-group">
                            <input type="password" name="inputCPassword" id="inputCPassword" class="form-control" placeholder="Password" required>
                            <label for="inputConfirmPassword">Confirm password</label>
                        </div>

                        <div align="center" class="g-recaptcha" data-sitekey="6LeuVH0UAAAAAOvb2yHd9wlV743BZ5V1b3FQOmPl"></div><br>

                        <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Register</button>
                        <a class="d-block text-center mt-2 small" href="login.php">Sign In</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark footer">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; SudokuMAX 2019</p>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="js/jquery/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>

</body>

</html>
