<?php
$host = "sql12.freesqldatabase.com";
$username = "sql12786152";
$password = "Ig5nlVxRrT";
$dbname = "sql12786152";

// Make sure to use $link
$link = mysqli_connect($host, $username, $password, $dbname);

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}
?>