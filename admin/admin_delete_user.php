<?php
session_start();
header('Content-Type: application/json');
if ($_SESSION['admin_logged_in'] !== true) {
  echo json_encode(['status' => 'error', 'message' => '無權限']);
  exit;
}
$id = intval($_POST['id'] ?? 0);
$link = mysqli_connect("localhost", "root", "", "db");
mysqli_query($link, "DELETE FROM account WHERE id = $id");
echo json_encode(['status' => 'success']);
