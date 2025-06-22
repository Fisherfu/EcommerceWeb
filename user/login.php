<?php
session_start();

// Absolute path to config.php
require_once dirname(__DIR__) . '/config.php';

// Check if username and password are set
if (isset($_POST['name']) && isset($_POST['password'])) {
    $name = trim($_POST['name']);
    $password = trim($_POST['password']);

    // Validate non-empty input
    if ($name === '' || $password === '') {
        echo "<script>alert('請輸入帳號和密碼'); location.href='index_login.php';</script>";
        exit();
    }

    // Escape inputs to prevent SQL injection
    $name = mysqli_real_escape_string($link, $name);
    $password = mysqli_real_escape_string($link, $password);

    // Prepare and execute query
    $sql = "SELECT * FROM account WHERE name='$name' AND password='$password'";
    $result = mysqli_query($link, $sql);

    // Check for matching user
    if (mysqli_num_rows($result) === 1) {
        $_SESSION['name'] = $name;
        echo "<script>alert('登入成功'); location.href='../index_product.php';</script>";
    } else {
        echo "<script>alert('帳號或密碼錯誤'); location.href='index_login.php';</script>";
    }
} else {
    echo "<script>alert('請輸入帳號和密碼'); location.href='index_login.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>買/賣家登入</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
        font-family: Arial, sans-serif;
        background: url("loginPage.png") no-repeat center center fixed;
        background-size: cover;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container {
        background: rgba(255, 255, 255, 0.9);
        padding: 30px;
        border-radius: 12px;
        max-width: 400px;
        width: 100%;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        position: relative;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: bold;
    }

    .form-group { margin-bottom: 16px; }
    label { display: block; margin-bottom: 6px; }
    input {
        width: 100%;
        padding: 10px;
        font-size: 15px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    button {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        background-color: #007BFF;
        color: #fff;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    button:hover { background-color: #0056b3; }

    .error {
        color: #d93025;
        text-align: center;
        margin-bottom: 16px;
    }

    .top-right, .top-left {
        position: absolute;
        top: 20px;
        font-weight: bold;
    }

    .top-right {
        right: 20px;
    }

    .top-left {
        left: 20px;
    }

    .top-right a, .top-left a {
        color: #673ab7;
        text-decoration: none;
    }

    .top-right a:hover, .top-left a:hover {
        text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="top-left">
    <a href="index_logout.php">首頁</a>
  </div>

  <div class="top-right">
    <a href="../admin/adminLogin.html">後台登入</a>
  </div>

  <div class="container">
    <h1>使用者登入</h1>
    <?php if ($error): ?>
      <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form action="login.php" method="post">
      <div class="form-group">
        <label for="name">帳號</label>
        <input type="text" id="name" name="name" required>
      </div>
      <div class="form-group">
        <label for="password">密碼</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit">登入</button>
    </form>
  </div>

</body>
</html>
