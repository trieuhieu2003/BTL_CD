<?php
session_start(); // Bắt đầu session
session_unset(); // Xóa tất cả các biến session
session_destroy(); // Hủy session hoàn toàn

// Chuyển hướng về login.php
header("Location: ../login.php");
exit(); // Dừng thực thi script
?>