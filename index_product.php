<?php include "db_product.php"; ?>

<?php
// 取得搜尋條件
$keyword = $_GET['keyword'] ?? '';
$sort = $_GET['sort'] ?? '';
$category_id = $_GET['category_id'] ?? '';

// 撈所有分類
$allCategories = $pdo->query("SELECT * FROM categories")->fetchAll();

// 排序條件
$orderBy = "p.id DESC";
switch ($sort) {
    case 'price_asc':  $orderBy = "p.price ASC"; break;
    case 'price_desc': $orderBy = "p.price DESC"; break;
    case 'stock_asc':  $orderBy = "p.stock_quantity ASC"; break;
    case 'stock_desc': $orderBy = "p.stock_quantity DESC"; break;
}

// SQL 查詢 + 篩選
$sql = "
    SELECT p.*, c.name AS category_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.name LIKE :keyword
";
$params = ['keyword' => "%$keyword%"];

if ($category_id !== '') {
    $sql .= " AND p.category_id = :category_id";
    $params['category_id'] = $category_id;
}

$sql .= " ORDER BY $orderBy";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>商品後台管理</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <h1 class="mb-4">📦 商品後台管理</h1>

    <!-- 🔍 搜尋與篩選 -->
    <form method="get" class="row g-3 mb-4">
        <div class="col-auto">
            <input type="text" name="keyword" class="form-control" placeholder="搜尋商品名稱" value="<?= htmlspecialchars($keyword) ?>">
        </div>

        <div class="col-auto">
            <select name="category_id" class="form-select">
                <option value="">全部分類</option>
                <?php foreach ($allCategories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $category_id == $cat['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-auto">
            <select name="sort" class="form-select">
                <option value="">排序方式</option>
                <option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>價格：低 → 高</option>
                <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>價格：高 → 低</option>
                <option value="stock_asc" <?= $sort === 'stock_asc' ? 'selected' : '' ?>>庫存：少 → 多</option>
                <option value="stock_desc" <?= $sort === 'stock_desc' ? 'selected' : '' ?>>庫存：多 → 少</option>
            </select>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> 搜尋</button>
        </div>

        <div class="col-auto ms-auto d-flex gap-2">
            <a href="category_product.php" class="btn btn-outline-secondary"><i class="bi bi-folder"></i> 分類管理</a>
            <a href="add_product.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> 新增商品</a>
        </div>
    </form>

    <!-- 📋 商品清單 -->
    <table class="table table-bordered table-hover bg-white">
        <thead class="table-secondary">
            <tr>
                <th>商品名稱</th>
                <th>分類</th>
                <th>價格</th>
                <th>庫存</th>
                <th>圖片</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['category_name'] ?? '未分類') ?></td>
                <td>$<?= number_format($product['price'], 2) ?></td>
                <td><?= $product['stock_quantity'] ?></td>
                <td>
                    <img src="<?= $product['image'] ?: 'images/default.png' ?>" width="60">
                </td>
                <td>
                    <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i> 編輯</a>
                    <a href="delete_product.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('確定要刪除嗎？')"><i class="bi bi-trash"></i> 刪除</a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>

</body>
</html>
