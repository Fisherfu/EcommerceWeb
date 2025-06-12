<?php
include "db_product.php";

// 檢查有無傳入 ID
if (!isset($_GET['id'])) {
    die("缺少商品 ID");
}

$id = $_GET['id'];

// 先確認商品是否存在
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    die("找不到該商品");
}

// 執行刪除
$stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
$stmt->execute([$id]);

header("Location: index_product.php");
exit;
?>
