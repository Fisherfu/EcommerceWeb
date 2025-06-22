<?php
$host = "sql12.freesqldatabase.com";
$username = "sql12786152";
$password = "lg5nIVxRrT";
$dbname = "sql12786152";

$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
