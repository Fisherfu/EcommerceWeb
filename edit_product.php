<?php
include "db_product.php";

// 檢查有無傳入 id
if (!isset($_GET['id'])) {
    die("缺少商品 ID");
}
$id = $_GET['id'];

// 撈商品資料
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    die("找不到商品資料");
}

// 撈分類
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

// 處理表單提交
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'] ?: null;
    $stock_quantity = $_POST['stock_quantity'];
    $imagePath = $product['image']; // 預設保留原圖

    // 如果有選擇新圖片就上傳
    if (!empty($_FILES['image']['name'])) {
        $filename = uniqid() . "_" . $_FILES['image']['name'];
        $target = "images/" . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $imagePath = $target;
        }
    }

    // 更新資料
    $stmt = $pdo->prepare("UPDATE products SET name=?, price=?, image=?, category_id=?, stock_quantity=? WHERE id=?");
    $stmt->execute([$name, $price, $imagePath, $category_id, $stock_quantity, $id]);

    header("Location: index_product.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>編輯商品</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="mb-4">✏️ 編輯商品</h2>

    <form method="post" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
        <div class="mb-3">
            <label class="form-label">商品名稱</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">價格</label>
            <input type="number" name="price" class="form-control" step="0.01" value="<?= $product['price'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">分類</label>
            <select name="category_id" class="form-select">
                <option value="">-- 選擇分類 --</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= $c['id'] == $product['category_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">庫存數量</label>
            <input type="number" name="stock_quantity" class="form-control" value="<?= $product['stock_quantity'] ?>" min="0" required>
        </div>

        <div class="mb-3">
            <label class="form-label">目前圖片</label><br>
            <?php if ($product['image']): ?>
                <img src="<?= $product['image'] ?>" width="100">
            <?php else: ?>
                <img src="images/default.png" width="100">
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">更換圖片（可選）</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">更新商品</button>
        <a href="index_product.php" class="btn btn-secondary">取消</a>
    </form>
</div>

</body>
</html>
