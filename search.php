<?php
// search.php：提供輸入 ID 進行查詢的表單頁面

session_start();

// 未登入者導向 login.php，並停止程式
if (empty($_SESSION["admin_login_session"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>查詢</title>

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px; position: relative; }
        .home-link { position: absolute; top: 20px; right: 20px; }
        .container { max-width: 600px; margin: 60px auto 20px; background: #fff; padding: 20px; border-radius: 4px; }
        h1 { text-align: center; margin-bottom: 16px; }
        .form-group { margin-bottom: 12px; }
        label { display: block; margin-bottom: 4px; }
        input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 10px; background: #007BFF; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        a { display: inline-block; padding: 8px 12px; background: #007BFF; color: #fff; text-decoration: none; border-radius: 4px; }
        a:hover { background: #0056b3; }
        @media (min-width: 480px) { button { width: auto; } }
    </style>
</head>
<body>
    <!-- 首頁按鈕 -->
    <a class="home-link" href="index_login.php">首頁</a>

    <div class="container">
        <h1>查詢</h1>
        <!-- 查詢表單：使用 GET 方法將 ID 傳給 search_result.php -->
        <form action="search_result.php" method="get">
            <div class="form-group">
                <label>ID</label>
                <input name="id" required>
            </div>
            <button type="submit">查詢</button>
        </form>
    </div>
</body>
</html>
