<?php
$DB_HOST = 'sql12.freesqldatabase.com';
$DB_USER = 'sql12786152';
$DB_PASS = 'lg5nIVxRrT';
$DB_NAME = 'sql12786152';
$DB_PORT = 3306; // Optional but explicit

// 建立連線並加上錯誤訊息
$link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);

if (!$link) {
    // 印出詳細的錯誤資訊
    die("DB 連線失敗：<br>" .
        "Host: {$DB_HOST}<br>" .
        "User: {$DB_USER}<br>" .
        "DB: {$DB_NAME}<br>" .
        "Error: " . mysqli_connect_error());
}
?>



