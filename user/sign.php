<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
session_start();

function response($status, $message) {
    echo json_encode(['status' => $status, 'message' => $message]);
    exit;
}

// 檢查 reCAPTCHA
$secretKey = "6LdCgFQrAAAAALbhcL1NbX8q3hZl-p2Naj9lWbs-";
$recaptcha = $_POST['g-recaptcha-response'];
$verifyURL = "https://www.google.com/recaptcha/api/siteverify";
$verifyResponse = file_get_contents("$verifyURL?secret=$secretKey&response=$recaptcha");
$responseData = json_decode($verifyResponse);

if (!$responseData->success) {
    response('error', '驗證碼驗證失敗');
}

$name  = trim($_POST['value1'] ?? '');
$pwd   = trim($_POST['value2'] ?? '');
$phone = trim($_POST['value3'] ?? '');
$email = trim($_POST['value4'] ?? '');
$addr  = trim($_POST['value5'] ?? '');
$roles = $_POST['roles'] ?? [];

$is_buyer = in_array('buyer', $roles) ? 1 : 0;
$is_seller = in_array('seller', $roles) ? 1 : 0;
$is_admin = in_array('admin', $roles) ? 1 : 0;

// 驗證管理密碼（如果有勾 admin）
$admin_pass = trim($_POST['admin_pass'] ?? '');
$adminSecret = 'bear1234';

if ($is_admin && $admin_pass !== $adminSecret) {
    response('error', '後台管理密碼錯誤，無法註冊為管理者');
}
if (!$name || !$pwd || !$phone || !$email || !$addr) {
    response('error', '請填寫所有欄位');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    response('error', 'Email 格式錯誤');
}

if (!preg_match('/^[0-9]{8,15}$/', $phone)) {
    response('error', '電話號碼格式錯誤');
}

$link = mysqli_connect('localhost', 'root', '', 'db');
if (!$link) response('error', '資料庫連線失敗');

$result = mysqli_query($link, "SELECT * FROM account WHERE name = '$name'");
if (mysqli_num_rows($result) >= 1) {
    response('error', '帳號已存在');
}

$hashedPwd = password_hash($pwd, PASSWORD_BCRYPT);

$sql = "INSERT INTO account (name, password, phone, email, address, is_buyer, is_seller, is_admin)
        VALUES ('$name', '$hashedPwd', '$phone', '$email', '$addr', '$is_buyer', '$is_seller', '$is_admin')";

// $sql = ""
if (mysqli_query($link, $sql)) {
    response('success', '註冊成功！3 秒後自動跳轉');
} else {
    response('error', '資料寫入失敗');
}
