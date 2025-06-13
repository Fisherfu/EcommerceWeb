
<?php
$conn = new mysqli("localhost", "root", "", "db");
if ($conn->connect_error) die("連線失敗: " . $conn->connect_error);

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

$sql = "SELECT * FROM products WHERE name LIKE ?";
$params = ["s", "%" . $keyword . "%"];

// 加入排序
if ($sort == "price_asc") {
    $sql .= " ORDER BY price ASC";
} elseif ($sort == "price_desc") {
    $sql .= " ORDER BY price DESC";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param(...$params);
$stmt->execute();
$result = $stmt->get_result();
$hasResults = $result->num_rows > 0;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>商品搜尋</title>
    <link rel="stylesheet" href="style.css">
</head>
<?php include("header.php"); ?>
<h1>商品搜尋</h1>
<form>
    <input type="text" name="keyword" placeholder="輸入商品名稱" value="<?php echo htmlspecialchars($keyword); ?>">
    <select name="sort">
        <option value="">預設排序</option>
        <option value="price_asc" <?php if ($sort == "price_asc") echo "selected"; ?>>價格由低到高</option>
        <option value="price_desc" <?php if ($sort == "price_desc") echo "selected"; ?>>價格由高到低</option>
    </select>
    <button type="submit">搜尋</button>
</form>

<?php if ($hasResults): ?>
<div class="product-grid">
<?php while ($row = $result->fetch_assoc()): ?>
    <div class="product-card">
        <a href="user_product.php?id=<?php echo $row['id']; ?>">
            <img src="<?php echo '../' . $row['image']; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
            <p>NT$<?php echo number_format($row['price'], 0); ?></p>
        </a>
    </div>
<?php endwhile; ?>
</div>
<?php else: ?>
<p style="text-align:center; font-size:18px; color:#666;">抱歉，找不到您所查詢的「<?php echo htmlspecialchars($keyword); ?>」相關商品</p>
<?php endif; ?>

</body>
</html>
<?php $conn->close(); ?>
