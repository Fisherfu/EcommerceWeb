<?php
// delete.php：此檔案負責刪除 content 資料表中指定的 UID，並顯示刪除表單

// 啟用 session 機制
session_start();

// 檢查管理員登入狀態，若未登入則導向 login.php
if (empty($_SESSION["admin_login_session"])) {
    header("Location: login.php");
    exit;
}

// 當表單送出 id 欄位時，開始執行刪除
if (isset($_POST['id'])) {
    $id = $_POST['id']; // 取得要刪除的 UID

    // 連接資料庫，失敗則顯示錯誤
    $link = mysqli_connect('localhost','root','1234','db') or die('DB Error');
    // 組裝 DELETE 語句，刪除符合條件的紀錄
    $sql = "DELETE FROM content WHERE UID='$id'";
    mysqli_query($link, $sql); // 執行刪除
    mysqli_close($link);        // 關閉連線

    // 刪除成功後，顯示提示並導回主頁
    echo "<script>alert('刪除完成');location.href='index_login.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>刪除</title>
    <!-- 以下為頁面樣式設定 -->
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
    <!-- 返回主頁連結 -->
    <a class="home-link" href="index_login.php">首頁</a>
    <div class="container">
        <h1>刪除</h1>
        <!-- 刪除資料表單：輸入欲刪除的 UID，提交後自動執行刪除動作 -->
        <form method="post">
            <div class="form-group">
                <label>ID</label>
                <input name="id" required>
            </div>
            <button type="submit">刪除</button>
        </form>
    </div>
</body>
</html>
