<?php
$host = "sql12.freesqldatabase.com";
$username = "sql12786152";
$password = "Ig5nlVxRrT"; // make sure it is correct and up to date
$dbname = "sql12786152";

// Connect
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
