<?php
session_start(); // Bắt đầu session

// Xóa tất cả dữ liệu trong session
session_unset(); // Xóa tất cả biến session
session_destroy(); // Hủy session

// Chuyển hướng về trang đăng nhập
header('Location: login.php');
exit();
?>