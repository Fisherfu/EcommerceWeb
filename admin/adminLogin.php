<?php
session_start();
$link = mysqli_connect('localhost', 'root', '', 'db');
if (!$link) die('資料庫連線失敗');

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if (!$username || !$password) {
    header("Location: adminLogin.html?error=請填寫帳號密碼");
    exit;
}

// 查詢使用者
$sql = "SELECT * FROM account WHERE name = '$username' AND is_admin = 1";
$result = mysqli_query($link, $sql);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    header("Location: adminLogin.html?error=帳號不存在或不是管理者");
    exit;
}

// 驗證密碼
if (!password_verify($password, $user['password'])) {
    header("Location: adminLogin.html?error=密碼錯誤");
    exit;
}

// 記錄 session 並進入後台
$_SESSION['admin_logged_in'] = true;
$_SESSION['admin_name'] = $user['name'];
header("Location: adminPanel.php");
exit;
