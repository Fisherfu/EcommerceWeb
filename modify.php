<?php
// 啟用 session 機制，用於驗證管理員登入狀態
session_start();

// 如果管理員尚未登入，就導回登入頁面，並停止後續程式執行
if (empty($_SESSION["admin_login_session"])) {
    header("Location: login.php");
    exit;
}

// 若有收到表單送出的 UID、value1、value2、value3 四個欄位，就執行更新動作
if (isset($_POST['UID'], $_POST['value1'], $_POST['value2'], $_POST['value3'])) {
    // 從 POST 中取出使用者輸入的值
    $UID = $_POST['UID'];
    $v1 = $_POST['value1'];
    $v2 = $_POST['value2'];
    $v3 = $_POST['value3'];

    // 連接 MySQL 資料庫，失敗則輸出錯誤
    $link = mysqli_connect('localhost','root','1234','db') or die('DB Error');

    // 準備 UPDATE 語句，依據 UID 更新對應欄位
    $sql = "UPDATE content 
            SET value1='$v1', value2='$v2', value3='$v3' 
            WHERE UID='$UID'";

    // 執行 SQL，關閉連線
    mysqli_query($link, $sql);
    mysqli_close($link);

    // 更新成功後以 JavaScript 提示並導回主頁
    echo "<script>alert('修改完成');location.href='index_login.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>修改</title>
    <!-- 
        以下為頁面樣式，採用簡潔的響應式設計：
        - *：重置 margin/padding，box-sizing 改為 border-box
        - body：設定字型、背景色、內距
        - .home-link：首頁按鈕固定在右上角
        - .container：將表單置中並加上卡片式白底
        - h1、.form-group、input、button：標題、欄位與按鈕樣式
    -->
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
    <!-- 首頁按鈕，點擊可隨時回到 index_login.php -->
    <a class="home-link" href="index_login.php">首頁</a>

    <div class="container">
        <h1>修改</h1>
        <!-- 修改表單：提交後回傳到本頁面再由上方 PHP 片段處理 -->
        <form method="post">
            <div class="form-group">
                <label>ID</label>
                <input name="UID" required>
            </div>
            <div class="form-group">
                <label>Value 1</label>
                <input name="value1" required>
            </div>
            <div class="form-group">
                <label>Value 2</label>
                <input name="value2" required>
            </div>
            <div class="form-group">
                <label>Value 3</label>
                <input name="value3" required>
            </div>
            <button type="submit">更新</button>
        </form>
    </div>
</body>
</html>
