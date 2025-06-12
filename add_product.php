<?php
include "db_product.php";

// 送出表單後執行新增
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'] ?: null;
    $stock_quantity = $_POST['stock_quantity'];

    // 先處理圖片上傳（可選）
    $imagePath = null;
    if (!empty($_FILES['image']['name'])) {
        $filename = uniqid() . "_" . $_FILES['image']['name'];
        $target = "images/" . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $imagePath = $target;
        }
    }

    // 寫入資料庫
    $stmt = $pdo->prepare("INSERT INTO products (name, price, image, category_id, stock_quantity) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $price, $imagePath, $category_id, $stock_quantity]);

    header("Location: index_product.php");
    exit;
}

// 取得所有分類
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>新增商品</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="mb-4">➕ 新增商品</h2>

    <form method="post" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
        <div class="mb-3">
            <label class="form-label">商品名稱</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">價格</label>
            <input type="number" name="price" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label class="form-label">分類</label>
            <select name="category_id" class="form-select">
                <option value="">-- 選擇分類 --</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">庫存數量</label>
            <input type="number" name="stock_quantity" class="form-control" value="0" min="0" required>
        </div>

        <div class="mb-3">
            <label class="form-label">商品圖片（可選）</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">新增商品</button>
        <a href="index_product.php" class="btn btn-secondary">取消</a>
    </form>
</div>

</body>
</html>
