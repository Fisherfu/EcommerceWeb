
<?php
$conn = new mysqli("localhost", "root", "", "db");
if ($conn->connect_error) die("連線失敗: " . $conn->connect_error);
$result = $conn->query("SELECT * FROM products");
?>
<?php include("header.php"); ?>
<h1>商品總覽</h1>
<div class="product-grid">
<?php while ($row = $result->fetch_assoc()): ?>
    <div class="product-card">
        <a href="user_product.php?id=<?php echo $row['id']; ?>">        
            <?php if (!empty($row['image'])): ?>
                <img src="<?php echo '../' . htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
            <?php else: ?>
                <img src="image/default.png" alt="無圖示">
            <?php endif; ?>
            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
            <p>NT$<?php echo number_format($row['price'], 0); ?></p>
        </a>
    </div>
<?php endwhile; ?>
</div>
<?php $conn->close(); ?>

