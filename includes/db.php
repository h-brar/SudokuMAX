<?php
$dbhost = "localhost";
$dbuser = "f23b83fg_sofe272";
$dbpass = "sofe2720!";
$dbname = "f23b83fg_sofe2720";
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (mysqli_connect_errno()) {
    die ("Database connection failed: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")");
}
