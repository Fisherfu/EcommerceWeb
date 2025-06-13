<?php
session_start();
$conn = new mysqli("localhost", "root", "", "db");
if ($conn->connect_error) die("連線失敗: " . $conn->connect_error);
include("header.php");

// 更新數量
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    foreach ($_POST['quantities'] as $product_id => $qty) {
        if ($qty <= 0) {
            unset($_SESSION['cart'][$product_id]);
        } else {
            $_SESSION['cart'][$product_id] = (int)$qty;
        }
    }
    header("Location: user_cart.php");
    exit;
}

// 刪除單一商品
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    unset($_SESSION['cart'][$delete_id]);
    header("Location: user_cart.php");
    exit;
}
?>
<style>
    .cart-container {
        max-width: 800px;
        margin: 40px auto;
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .cart-container h2 {
        text-align: center;
        font-size: 28px;
        margin-bottom: 30px;
    }
    .cart-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    .cart-table th, .cart-table td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
    }
    .cart-table th {
        background-color: #f9f9f9;
    }
    .cart-table td input[type="number"] {
        width: 60px;
        padding: 4px;
    }
    .cart-actions {
        text-align: center;
        margin-top: 20px;
    }
    .cart-actions button {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 6px;
        margin: 5px;
    }
    .cart-actions button:hover {
        background-color: #45a049;
    }
    .delete-icon {
        display: inline-block;
        width: 20px;
        height: 20px;
        background-image: url('../image/delete_icon.png');
        background-size: cover;
        background-repeat: no-repeat;
        cursor: pointer;
    }
</style>
<div class="cart-container">
    <h2>🛒 我的購物車</h2>
    <?php if (empty($_SESSION['cart'])): ?>
        <p style="text-align:center;">購物車是空的。</p>
    <?php else: ?>
        <form method="post" action="user_cart.php">
            <table class="cart-table">
                <tr>
                    <th>商品名稱</th>
                    <th>單價</th>
                    <th>數量</th>
                    <th>小計</th>
                    <th>刪除</th>
                </tr>
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $product_id => $qty):
                    $res = $conn->query("SELECT name, price FROM products WHERE id = $product_id");
                    $row = $res->fetch_assoc();
                    $subtotal = $row['price'] * $qty;
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td>NT$ <?php echo number_format($row['price']); ?></td>
                    <td><input type="number" name="quantities[<?php echo $product_id; ?>]" value="<?php echo $qty; ?>" min="0"></td>
                    <td>NT$ <?php echo number_format($subtotal); ?></td>
                    <td><a href="user_cart.php?delete=<?php echo $product_id; ?>" class="delete-icon" title="刪除"></a></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" align="right"><strong>總金額：</strong></td>
                    <td colspan="2"><strong>NT$ <?php echo number_format($total); ?></strong></td>
                </tr>
            </table>
            <div class="cart-actions">
                <button type="submit" name="update">更新數量</button>
                <button type="button" onclick="location.href='checkout.php'">結帳</button>
            </div>
        </form>
    <?php endif; ?>
</div>
