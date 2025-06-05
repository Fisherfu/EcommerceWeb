<?php
session_start();
header('Content-Type: application/json');
if ($_SESSION['admin_logged_in'] !== true) {
  echo json_encode(['status' => 'error', 'message' => '未登入']);
  exit;
}

$link = mysqli_connect("localhost", "root", "", "db");
$id = intval($_POST['id']);
$name = mysqli_real_escape_string($link, $_POST['name']);
$phone = mysqli_real_escape_string($link, $_POST['phone']);
$email = mysqli_real_escape_string($link, $_POST['email']);
$address = mysqli_real_escape_string($link, $_POST['address']);
$is_buyer = isset($_POST['is_buyer']) ? 1 : 0;
$is_seller = isset($_POST['is_seller']) ? 1 : 0;
$is_admin = isset($_POST['is_admin']) ? 1 : 0;

// 密碼可選擇更改
$pwd = trim($_POST['password'] ?? '');
if ($pwd !== '') {
  $hashed = password_hash($pwd, PASSWORD_BCRYPT);
  $pwd_sql = ", password = '$hashed'";
} else {
  $pwd_sql = "";
}

$sql = "UPDATE account SET name='$name', phone='$phone', email='$email', address='$address',
        is_buyer=$is_buyer, is_seller=$is_seller, is_admin=$is_admin $pwd_sql
        WHERE id=$id";

mysqli_query($link, $sql);
echo json_encode(['status' => 'success', 'message' => '更新成功']);
