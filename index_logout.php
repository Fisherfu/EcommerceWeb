<?php
// index_logout.php：訪客或已登出狀態下的首頁
// ----------------------------------------------------------------------------------
// 1. 啟動 session（雖不檢查登入，但可保留以便未來擴充）
session_start();
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>首頁 (未登入)</title>
    <!-- 樣式與管理端首頁相似，提供一致的使用者體驗 -->
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
        <h1>歡迎訪客</h1>
        <p>請先登入或註冊以使用本系統</p>
        <div class="actions">
            <!-- 訪客可選擇登入或註冊新帳號 -->
            <a href="login.php">登入</a>
            <a href="register.html">註冊帳號</a>
        </div>
    </div>
</body>
</html>