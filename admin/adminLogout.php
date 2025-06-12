<?php
session_start();
session_unset();
session_destroy();
header("Location: ../user/login.php"); // 或跳轉到你的主首頁
exit;
