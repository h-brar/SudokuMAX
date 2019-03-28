<?php
$dbhost = "localhost";
$dbuser = "wpprojec_dbusr";
$dbpass = "g!BuqwgqQ#";
$dbname = "wpprojec_maindb";
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (mysqli_connect_errno()) {
    die ("Database connection failed: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")");
}
