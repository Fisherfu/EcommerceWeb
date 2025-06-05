<?php
// add.php：此檔案處理新增 content 資料至資料庫，並渲染新增表單

// 啟用 session，以便後續驗證使用者是否已登入
session_start();

// 驗證管理員是否已登入，若未登入則轉向 login.php
if (empty($_SESSION["admin_login_session"]) || $_SESSION["admin_login_session"] !== true) {
    header("Location: login.php"); // 導向登入頁面
    exit; // 停止執行，避免後續程式碼跑下去
}

// 初始化要接收的四個欄位變數
$UID = $value1 = $value2 = $value3 = "";

// 如果使用者透過表單 POST 送出，則把值帶入對應變數
if (isset($_POST["UID"])) $UID = $_POST["UID"];
if (isset($_POST["value1"])) $value1 = $_POST["value1"];
if (isset($_POST["value2"])) $value2 = $_POST["value2"];
if (isset($_POST["value3"])) $value3 = $_POST["value3"];

// 當所有欄位都有填寫時，才執行資料庫新增
if ($UID !== "" && $value1 !== "" && $value2 !== "" && $value3 !== "") {
    // 連接 MySQL 資料庫，若失敗則顯示錯誤並結束程式
    $link = mysqli_connect('localhost','root','1234','db') or die('DB Connect Error');
    // 組裝 INSERT 語法，將表單內容存入 content 表
    $sql = "INSERT INTO content (UID, value1, value2, value3) VALUES ('$UID','$value1','$value2','$value3')";
    mysqli_query($link, $sql); // 執行 SQL
    mysqli_close($link);        // 關閉資料庫連線
    echo "<script>alert('新增成功');location.href='index_login.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>新增</title>
    <!-- 以下為頁面樣式設定：重置、佈局與按鈕樣式 -->
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
    <!-- 首頁連結，方便隨時回到主頁 -->
    <a class="home-link" href="index_login.php">首頁</a>
    <div class="container">
        <h1>新增</h1>
        <!-- 新增資料表單：填寫欄位後送出至本頁面自行處理 -->
        <form action="add.php" method="post">
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
            <button type="submit">送出</button>
        </form>
    </div>
</body>
</html>
