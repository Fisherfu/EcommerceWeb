<?php
header('Content-Type: application/json');
require_once("../config.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
session_start();

function response($status, $message) {
    echo json_encode(['status' => $status, 'message' => $message]);
    exit;
}

// 检查 reCAPTCHA
// $secretKey = "your-secret-key";
// $recaptcha = $_POST['g-recaptcha-response'];
// $verifyURL = "https://www.google.com/recaptcha/api/siteverify";
// $verifyResponse = file_get_contents("$verifyURL?secret=$secretKey&response=$recaptcha");
// $responseData = json_decode($verifyResponse);
// if (!$responseData->success) {
//    response('error', '验证码验证失败');
// }

$name  = trim($_POST['value1'] ?? '');
$pwd   = trim($_POST['value2'] ?? '');
$phone = trim($_POST['value3'] ?? '');
$email = trim($_POST['value4'] ?? '');
$addr  = trim($_POST['value5'] ?? '');
$roles = $_POST['roles'] ?? [];

$is_buyer = in_array('buyer', $roles) ? 1 : 0;
$is_seller = in_array('seller', $roles) ? 1 : 0;
$is_admin = in_array('admin', $roles) ? 1 : 0;

// 验证管理员密码（如果勾选了admin）
$admin_pass = trim($_POST['admin_pass'] ?? '');
$adminSecret = 'bear1234';

if ($is_admin && $admin_pass !== $adminSecret) {
    response('error', '后台管理密码错误，无法注册为管理员');
}

if (!$name || !$pwd || !$phone || !$email || !$addr) {
    response('error', '请填写所有字段');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    response('error', 'Email 格式错误');
}

if (!preg_match('/^[0-9]{8,15}$/', $phone)) {
    response('error', '电话号码格式错误');
}

// Update the connection to the remote database
$link = mysqli_connect('sql12.freesqldatabase.com', 'sql12786152', 'Ig5nlVxRrT', 'sql12786152'); // Update credentials
if (!$link) {
    response('error', '數據庫連線失敗');
}

// Use prepared statements to prevent SQL injection
$stmt = $link->prepare("SELECT * FROM account WHERE name = ?");
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

if (mysqli_num_rows($result) >= 1) {
    response('error', '账户已存在');
}

$hashedPwd = password_hash($pwd, PASSWORD_BCRYPT);

$stmt = $link->prepare("INSERT INTO account (name, password, phone, email, address, is_buyer, is_seller, is_admin)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssiii", $name, $hashedPwd, $phone, $email, $addr, $is_buyer, $is_seller, $is_admin);

if ($stmt->execute()) {
    response('success', '注册成功！3秒后自动跳转');
} else {
    response('error', '数据写入失败');
}

?>
