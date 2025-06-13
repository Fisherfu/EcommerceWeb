<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$conn = new mysqli("localhost", "root", "", "db");
if ($conn->connect_error) die("資料庫連線失敗: " . $conn->connect_error);
$cat_result = $conn->query("SELECT * FROM categories");
$cart_count = array_sum($_SESSION['cart'] ?? []);
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>會員商城系統</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .navbar {
            display: flex;
            justify-content: center;
            background-color: #fff;
            border-bottom: 1px solid #eee;
            padding: 12px;
            font-size: 18px;
            gap: 40px;
            position: relative;
            z-index: 20;
        }
        .navbar a {
            text-decoration: none;
            color: #333;
            padding: 8px;
        }
        .navbar a:hover {
            color: #4CAF50;
        }
        .navbar .dropdown {
            position: relative;
        }
        .navbar .dropdown-content {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 140px;
            background-color: #fffaf5;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            border-radius: 8px;
            z-index: 99;
        }
        .navbar .dropdown-content a {
            display: block;
            padding: 10px;
            color: #333;
        }
        .navbar .dropdown-content a:hover {
            background-color: #f2f2f2;
        }
        .navbar .dropdown:hover .dropdown-content {
            display: block;
        }
        .navbar .dropdown > a::after {
            content: ' ▼';
            font-size: 14px;
        }
        .navbar .dropdown:hover > a::after {
            content: ' ▲';
        }
        h1 {
            text-align: center;
            margin: 30px 0;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="nav-item"><a href="user_allproduct.php">首頁</a></div>
    <div class="nav-item"><a href="user_search.php">商品搜尋</a></div>

    <!-- 商品分類 -->
    <div class="nav-item dropdown">
        <a href="#">商品分類</a>
        <div class="dropdown-content">
            <?php if ($cat_result && $cat_result->num_rows > 0): ?>
                <?php while ($cat = $cat_result->fetch_assoc()): ?>
                    <a href="user_category.php?id=<?php echo $cat['id']; ?>">
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </a>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- 會員功能 -->
    <div class="nav-item dropdown">
        <a href="#">會員</a>
        <div class="dropdown-content">
            <a href="user_profile.php">會員資料</a>
            <a href="login.php">登出</a>
        </div>
    </div>

    <!-- 購物車圖示 -->
    <div class="nav-item">
        <a href="user_cart.php">
            <img src="../image/cart_icon.png" alt="購物車" style="height:24px;">
            <?php if ($cart_count > 0): ?>
                <span style="color:red;font-weight:bold;">(<?php echo $cart_count; ?>)</span>
            <?php else: ?>
                <span style="color:#999;">(0)</span>
            <?php endif; ?>
        </a>
    </div>
</div>
