<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.html");
    exit;
}

$link = mysqli_connect("localhost", "root", "", "db");
if (!$link) die("連線資料庫失敗");

$search = trim($_GET['search'] ?? '');
if ($search !== '') {
    $sql = "SELECT * FROM account WHERE phone LIKE '%$search%' ORDER BY id DESC LIMIT 50";
} else {
    $sql = "SELECT * FROM account ORDER BY id DESC LIMIT 50";
}
$result = mysqli_query($link, $sql);
$num_rows = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <title>使用者後台管理</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-light">
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">使用者管理後台</h3>
  <a href="adminLogout.php" class="btn btn-outline-danger">登出</a>
</div>

  <form method="get" class="row g-2 mb-3">
    <div class="col-auto">
      <input type="text" name="search" class="form-control" placeholder="輸入電話查詢" value="<?= htmlspecialchars($search) ?>">
    </div>
    <div class="col-auto">
      <button class="btn btn-primary">搜尋</button>
    </div>
    <div class="col-auto">
      <a href="adminPanel.php" class="btn btn-secondary">清除搜尋</a>
    </div>
  </form>

<?php if ($num_rows === 0): ?>
  <p class="text-muted">
    <?= $search !== '' ? '查無符合電話「' . htmlspecialchars($search) . '」的使用者。' : '目前尚無使用者資料。' ?>
  </p>
<?php else: ?>
  <table class="table table-bordered bg-white">
    <thead>
      <tr>
        <th>ID</th><th>帳號</th><th>密碼</th><th>電話</th><th>Email</th><th>地址</th><th>角色</th><th>操作</th>
      </tr>
    </thead>
    <tbody>
      <?php while($u = mysqli_fetch_assoc($result)): ?>
      <tr id="row-<?= $u['id'] ?>">
        <form class="updateForm" data-id="<?= $u['id'] ?>">
        <td><?= $u['id'] ?></td>
        <td><input name="name" value="<?= htmlspecialchars($u['name']) ?>" class="form-control" required></td>
        <td><input name="password" placeholder="留空不更改" class="form-control" type="password"></td>
        <td><input name="phone" value="<?= htmlspecialchars($u['phone']) ?>" class="form-control" required></td>
        <td><input name="email" value="<?= htmlspecialchars($u['email']) ?>" class="form-control"></td>
        <td><input name="address" value="<?= htmlspecialchars($u['address']) ?>" class="form-control"></td>
        <td>
          <label><input type="checkbox" name="is_buyer" <?= $u['is_buyer'] ? 'checked' : '' ?>> 買家</label><br>
          <label><input type="checkbox" name="is_seller" <?= $u['is_seller'] ? 'checked' : '' ?>> 賣家</label><br>
          <label><input type="checkbox" name="is_admin" <?= $u['is_admin'] ? 'checked' : '' ?>> 管理者</label>
        </td>
        <td>
          <button type="submit" class="btn btn-sm btn-success mb-2">儲存</button>
          <button type="button" class="btn btn-sm btn-danger" onclick="deleteUser(<?= $u['id'] ?>)">刪除</button>
        </td>
        </form>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
<?php endif; ?>
</div>

<script>
function deleteUser(id) {
  if (!confirm("確定刪除使用者？")) return;
  $.post("admin_delete_user.php", { id }, function (res) {
    if (res.status === 'success') {
      $('#row-' + id).remove();
    } else {
      alert(res.message);
    }
  }, 'json');
}

$('.updateForm').on('submit', function (e) {
  e.preventDefault();
  const form = $(this);
  const id = form.data('id');
  const data = form.serialize() + '&id=' + id;
  $.post('admin_update_user.php', data, function (res) {
    alert(res.message);
  }, 'json');
});
</script>
</body>
</html>
