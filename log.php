<?php
session_start(); // Bắt đầu session

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qlbanhang";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sử dụng Prepared Statement
$stmt = $conn->prepare("SELECT id, fullname, email FROM customers WHERE email = ? AND password = ?");
$stmt->bind_param("ss", $_POST["email"], md5($_POST["pass"]));
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Gán giá trị vào session
    $_SESSION["user"] = $row['email'];
    $_SESSION["fullname"] = $row['fullname'];
    $_SESSION["id"] = $row['id'];
    
    header('Location: homepage.php');
    exit();
} else {
    echo "Error: No user found.";
    header('Refresh: 3;url=login.php');
}

// Đóng statement và kết nối
$stmt->close();
$conn->close();
?>
