<?php
include "db_product.php";

// ✅ 新增分類
if (isset($_POST['action']) && $_POST['action'] === 'add') {
    $name = trim($_POST['name']);
    if ($name !== '') {
        $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->execute([$name]);
    }
    header("Location: category_product.php");
    exit;
}

// ✅ 修改分類
if (isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    if ($name !== '') {
        $stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
        $stmt->execute([$name, $id]);
    }
    header("Location: category_product.php");
    exit;
}

// ✅ 刪除分類
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: category_product.php");
    exit;
}

// 抓全部分類
$categories = $pdo->query("SELECT * FROM categories ORDER BY id ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <title>分類管理</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <h2 class="mb-4">📁 分類管理</h2>

        <!-- ➕ 新增分類 -->
        <form method="post" class="row g-3 mb-4">
            <input type="hidden" name="action" value="add">
            <div class="col-auto">
                <input type="text" name="name" class="form-control" placeholder="輸入分類名稱" required>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-success">新增分類</button>
            </div>
        </form>

        <!-- 📋 分類列表 -->
        <table class="table table-bordered bg-white">
            <thead class="table-secondary">
                <tr>
                    <th>分類名稱</th>
                    <th style="width: 180px">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $cat): ?>
                    <tr>
                        <form method="post" class="d-flex">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                            <td>
                                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($cat['name']) ?>" required>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary btn-sm">儲存</button>
                                <a href="category_product.php?delete=<?= $cat['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('確定刪除分類？')">刪除</a>
                            </td>
                        </form>
                    </tr>

                <?php endforeach ?>
            </tbody>
        </table>

        <a href="index_product.php" class="btn btn-secondary mt-4">返回商品列表</a>
    </div>

</body>

</html>