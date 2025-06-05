<?php
// index_login.php：管理員登入後的主控台首頁
// ----------------------------------------------------------------------------------
// 1. 啟動 session，以便驗證管理者是否已登入
session_start();

// 2. 驗證是否已經通過管理者登入
if (empty($_SESSION["user_name"]) || $_SESSION["user_logged_in"] !== true) {
    // 若沒有登入，轉回 login.php 進行登入動作
    header("Location: login.php");
    exit; // 停止後續程式執行
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>主頁</title>
    <!-- 版面與按鈕樣式設定，採用簡潔的卡片式設計 -->
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 4px; }
        h1 { text-align: center; margin-bottom: 16px; }
        p { text-align: center; margin-bottom: 24px; }
        .actions { display: flex; flex-direction: column; gap: 12px; }
        .actions a { display: block; text-align: center; padding: 10px 0; background: #007BFF; color: #fff; text-decoration: none; border-radius: 4px; }
        .actions a:hover { background: #0056b3; }
        @media (min-width: 480px) {
            .actions { flex-direction: row; justify-content: center; }
            .actions a { flex: 1; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>管理者操作</h1>
        <p>請選擇以下功能：</p>
        <div class="actions">
            <!-- 一鍵導向各管理功能 -->
            <a href="add.php">新增</a>
            <a href="delete.php">刪除</a>
            <a href="modify.php">修改</a>
            <a href="search.php">查詢</a>
            <a href="index_logout.php">登出</a>
        </div>
    </div>
</body>
</html>