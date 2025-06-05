<?php
// search_result.php：接收 ID 後執行資料庫查詢，並顯示結果

session_start();

// 登入檢查，未登入則導回 login.php
if (empty($_SESSION["admin_login_session"])) {
    header("Location: login.php");
    exit;
}

// 若沒有帶入 id 參數，就導回查詢頁面
if (!isset($_GET['id'])) {
    header('Location: search.php');
    exit;
}

// 取得要查詢的 ID
$id = $_GET['id'];

// 連接資料庫，失敗則顯示錯誤
$link = mysqli_connect('localhost','root','1234','db') or die('DB Error');

// 準備並執行 SELECT 語句
$sql = "SELECT * FROM content WHERE UID='$id'";
$res = mysqli_query($link, $sql);
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>查詢結果</title>
    <!--
        與其他頁面相同的樣式設定
    -->
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px; position: relative; }
        .home-link { position: absolute; top: 20px; right: 20px; }
        .container { max-width: 600px; margin: 60px auto 20px; background: #fff; padding: 20px; border-radius: 4px; }
        h1 { text-align: center; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        a { display: inline-block; padding: 8px 12px; background: #007BFF; color: #fff; text-decoration: none; border-radius: 4px; }
        a:hover { background: #0056b3; }
        @media (max-width: 480px) {
            table, thead, tbody, tr, th, td { display: block; }
            th, td { text-align: right; position: relative; padding-left: 50%; }
            th::before, td::before { position: absolute; left: 10px; width: 45%; white-space: nowrap; }
            th::before { content: attr(data-label); }
            td::before { content: attr(data-label); }
        }
    </style>
</head>
<body>
    <!-- 返回查詢頁的連結 -->
    <a class="home-link" href="index_login.php">首頁</a>

    <div class="container">
        <h1>查詢結果</h1>

        <?php if (mysqli_num_rows($res) > 0): ?>
            <!-- 若有找到資料，就以表格形式顯示 -->
            <table>
                <thead>
                    <tr>
                        <th>UID</th>
                        <th>Value 1</th>
                        <th>Value 2</th>
                        <th>Value 3</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($res)): ?>
                        <tr>
                            <td><?php echo $row['UID'];   ?></td>
                            <td><?php echo $row['value1']; ?></td>
                            <td><?php echo $row['value2']; ?></td>
                            <td><?php echo $row['value3']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <!-- 找不到時顯示無紀錄訊息 -->
            <p style="text-align:center;">無此紀錄</p>
        <?php endif;

        // 查詢結束後關閉資料庫連線
        mysqli_close($link);
        ?>

        <!-- 底部再提供一次「返回查詢」的快捷連結 -->
        <p style="text-align:center;"><a href="search.php">返回查詢</a></p>
    </div>
</body>
</html>
