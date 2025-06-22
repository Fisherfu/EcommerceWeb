



<?php
$DB_HOST = 'sql12.freesqldatabase.com';
$DB_USER = 'sql12786152';
$DB_PASS = 'lg5nIVxRrT';
$DB_NAME = 'sql12786152';

$link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if (!$link) {
    die('DB 連線失敗: ' . mysqli_connect_error());
}
?>
