<?php
session_start();

// 檢查 POST 傳入的資料是否正確
if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
    die("請從合法的表單送出資料");
}

$product_id = intval($_POST['product_id']);
$quantity = max(1, intval($_POST['quantity'])); // 數量最少為 1

// 初始化購物車（第一次建立）
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// 商品已存在 → 加總；否則新增
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] += $quantity;
} else {
    $_SESSION['cart'][$product_id] = $quantity;
}

// 加入成功後導向購物車頁面
header("Location: user_cart.php");
exit;
?>
