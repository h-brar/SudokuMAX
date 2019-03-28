<?php
session_start();

require 'includes/db.php';
require 'includes/def.php';

$theHTML = "";
$successMsg = "";

if ( isset( $_SESSION['user_id'] ) ) {
} else {
    header("Location: http://sofe2720.veloxcloud.ca/login.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION["orderedSeats"]) && !isset($_POST["filterTheatre"])) {
    $movie = $_SESSION["movie"];
    $name = $_SESSION["orderName"];
    $theatre = $_SESSION["theatre"];
    $showdate = $_SESSION["showdate"];
    $showtime = $_SESSION["showtime"];
    $seats = $_SESSION["orderedSeats"];
    $price = $_SESSION["price"];
    $address = $_SESSION["address"];

    $sql = "INSERT INTO orders (name,movie,theatre,date,showtime,seats) VALUES ('{$connection->real_escape_string($name)}',
        '{$connection->real_escape_string($movie)}',
        '{$connection->real_escape_string($theatre)}',
        '{$connection->real_escape_string($showdate)}',
        '{$connection->real_escape_string($showtime)}',
        '{$connection->real_escape_string($seats)}' )";

    $insert = $connection->query($sql);

    if ($insert == TRUE) {
        $successMsg = '<div class="alert alert-success text-center" role="alert"><strong>Success!</strong> Your seats have been reserved! An email has been sent to you with this info!</div>';
        $user = $_SESSION['user_id'];
        session_destroy();
        session_start();
        $_SESSION['user_id'] = $user;
        orderMail($user,$name,$movie,$theatre,$address,$showdate,$showtime,$seats,$price);
    }
    else {
        die("Error: {$connection->errno} : {$connection->error}");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["filterTheatre"])) {
    $theatreArray = theatreArray($_POST["filterTheatre"]);
    $theatreID = $theatreArray['id'];
    $sql = "SELECT * FROM (
                  SELECT * FROM movies WHERE INSTR(theatres, '{$theatreID}')
                ) sub
                ORDER BY id ASC";
    $result = $connection->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $theHTML .= '
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card">
                        <img class="card-img-top" height="150" src="img/thumbnails/' . $row['image'] . '" alt="">
                        <div class="card-body d-flex flex-column">
                            <h4 class="card-title">' . $row["name"] . '<br><small class="text-muted">' . $row["pRating"] . '</small></h4>
                            <p class="card-text">' . substr($row["description"], 0, 150) . '...</p>
                            <div class="mt-auto">
                                <h4>' . $row["price"] . '</h4>
                                <div class="ratings">
		                            ' . starRating($row['rating']) . '
	                            </div>
	                        </div>
                        </div>
                        <div class="card-footer">
                            <a href="order.php?id=' . $row["id"] . '" class="btn btn-primary">More Info/Watch!</a>
                        </div>
                    </div>
                </div>
                ';
        }
    }
}
else {
    $sql = "SELECT * FROM (
                  SELECT * FROM movies ORDER BY id DESC LIMIT 20
                ) sub
                ORDER BY id ASC";
    $result = $connection->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $theHTML .= '
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card">
                        <img class="card-img-top" height="150" src="img/thumbnails/' . $row['image'] . '" alt="">
                        <div class="card-body d-flex flex-column">
                            <h4 class="card-title">' . $row["name"] . '<br><small class="text-muted">' . $row["pRating"] . '</small></h4>
                            <p class="card-text">' . substr($row["description"], 0, 150) . '...</p>
                            <div class="mt-auto">
                                <h4>' . $row["price"] . '</h4>
                                <div class="ratings">
		                            ' . starRating($row['rating']) . '
	                            </div>
	                        </div>
                        </div>
                        <div class="card-footer">
                            <a href="order.php?id=' . $row["id"] . '" class="btn btn-primary">More Info/Watch!</a>
                        </div>
                    </div>
                </div>
                ';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SudokuMAX - Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/heroic-features.css" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

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
                        <a class="nav-link active" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout (' . $_SESSION["user_id"] . ')</a>
                    </li>
                    ';
                }
                else {
                    echo '
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
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

<!-- Page Content -->
<div class="container">

    <!-- Jumbotron Header -->
    <header class="jumbotron my-4">
        <h1 class="display-4">Hey there <?php echo $_SESSION['user_id']; ?>!</h1>
        <hr>
        <p class="lead">The best Sudoku you can find online!</p>
		<a href="game.php" class="btn btn-primary btn-lg">Play Now!</a>
    </header>

</div>
<!-- /.container -->

<!-- Footer -->
<footer class="footer bg-dark">
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
