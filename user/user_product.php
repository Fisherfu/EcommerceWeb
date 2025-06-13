<?php
session_start();
$conn = new mysqli("localhost", "root", "", "db");
if ($conn->connect_error) die("連線失敗: " . $conn->connect_error);

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
?>
<?php include("header.php"); ?>
<?php if ($product): ?>
    <div class="product-card" style="max-width:400px;margin:auto;">
        <img src="<?php echo '../' . $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
        <p><strong>價格：</strong>NT$<?php echo number_format($product['price'], 0); ?></p>

        <form action="user_addToCart.php" method="post">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <label for="quantity">數量：</label>
            <input type="number" name="quantity" value="1" min="1" style="width: 60px;">
            <br><br>
            <button type="submit">加入購物車</button>
        </form>

        <p><a href="user_allproduct.php">← 回商品列表</a></p>
    </div>
<?php else: ?>
    <p style="text-align:center;">找不到該商品。</p>
<?php endif; ?>
<?php $conn->close(); ?>