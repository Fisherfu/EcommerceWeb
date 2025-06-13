<?php
$conn = new mysqli("localhost", "root", "", "db");
if ($conn->connect_error) die("連線失敗");

// 檢查有沒有傳分類 ID
if (isset($_GET['id'])) {
    $category_id = (int)$_GET['id'];

    // 撈該分類的商品
    $sql = "SELECT * FROM products WHERE category_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // 撈分類名稱
    $name_sql = "SELECT name FROM categories WHERE id = ?";
    $name_stmt = $conn->prepare($name_sql);
    $name_stmt->bind_param("i", $category_id);
    $name_stmt->execute();
    $name_result = $name_stmt->get_result();
    $category_row = $name_result->fetch_assoc();
    $category_name = $category_row ? $category_row['name'] : "未知分類";

} else {
    // 沒傳 id，顯示所有商品
    $result = $conn->query("SELECT * FROM products");
    $category_name = "全部商品";
}
?>
<?php include("header.php"); ?>
<h1><?php echo htmlspecialchars($category_name); ?>｜商品列表</h1>

<div class="product-grid">
<?php while ($row = $result->fetch_assoc()): ?>
    <div class="product-card">
        <a href="user_product.php?id=<?php echo $row['id']; ?>">
            <img src="../<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
            <p>NT$<?php echo number_format($row['price'], 0); ?></p>
        </a>
    </div>
<?php endwhile; ?>
</div>