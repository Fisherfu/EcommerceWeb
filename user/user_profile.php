<?php
session_start();
include("header.php"); // 導覽列先出現

if (!isset($_SESSION['user_id'])) {
    echo "<h2 style='text-align:center; color: red;'>⚠️ 尚未登入，請先登入才能查看會員資料。</h2>";
    exit();
}

// 資料庫連線
$conn = new mysqli("localhost", "root", "", "db");
if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}

// 取得會員資料
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM account WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "<h2 style='text-align:center; color: red;'>⚠️ 找不到會員資料。</h2>";
    exit();
}
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<h1>會員資料</h1>
<div style="max-width: 600px; margin: 0 auto; background-color: #fffaf5; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); font-size: 18px;">
    <p><strong>帳號：</strong> <?php echo htmlspecialchars($user['name']); ?></p>
    <p><strong>電話：</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
    <p><strong>Email：</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>地址：</strong> <?php echo htmlspecialchars($user['address']); ?></p>
    <p><strong>身分：</strong>
        <?php
            $roles = [];
            if ($user['is_buyer'])  $roles[] = "買家";
            if ($user['is_seller']) $roles[] = "賣家";
            if ($user['is_admin'])  $roles[] = "管理員";
            echo implode("、", $roles);
        ?>
    </p>
</div>
