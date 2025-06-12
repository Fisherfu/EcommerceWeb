<?php
$host = 'localhost';
$dbname = 'test';
$user = 'root';
$pass = 'ian880925';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    // 設定錯誤模式為 Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("連線失敗：" . $e->getMessage());
}
?>
