<?php
session_start(); // Bắt đầu session

if (!isset($_SESSION["user"])) {
    header('Location: login.php'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qlbanhang";
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Xử lý form khi người dùng gửi dữ liệu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_password = md5($_POST['old_pass']);
    $new_password = $_POST['new_pass'];
    $confirm_password = $_POST['confirm_pass'];

    // Kiểm tra mật khẩu cũ
    $stmt = $conn->prepare("SELECT password FROM customers WHERE id = ?");
    $stmt->bind_param("i", $_SESSION["id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && $row['password'] === $old_password) {
        // Kiểm tra mật khẩu mới
        if ($new_password === $confirm_password && $old_password !== md5($new_password)) {
            // Băm mật khẩu mới và cập nhật vào CSDL
            $new_password_hashed = md5($new_password);
            $update_stmt = $conn->prepare("UPDATE customers SET password = ? WHERE id = ?");
            $update_stmt->bind_param("si", $new_password_hashed, $_SESSION["id"]);
            if ($update_stmt->execute()) {
                $message = "Cập nhật mật khẩu thành công!";
            } else {
                $message = "Có lỗi xảy ra. Vui lòng thử lại.";
            }
            $update_stmt->close(); // Đóng statement ở đây
        } else {
            $message = "Mật khẩu mới không khớp hoặc giống với mật khẩu cũ.";
        }
    } else {
        $message = "Mật khẩu cũ không chính xác.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đổi Mật Khẩu</title>
</head>
<body>
    <h2>Đổi Mật Khẩu</h2>
    <form method="post" action="">
        <label for="old_pass">Mật khẩu cũ:</label><br>
        <input type="password" id="old_pass" name="old_pass" required><br><br>
        
        <label for="new_pass">Mật khẩu mới:</label><br>
        <input type="password" id="new_pass" name="new_pass" required><br><br>
        
        <label for="confirm_pass">Nhập lại mật khẩu mới:</label><br>
        <input type="password" id="confirm_pass" name="confirm_pass" required><br><br>
        
        <input type="submit" value="Cập nhật">
    </form>

    <?php
    if ($message) {
        echo "<p>$message</p>";
    }
    ?>
</body>
</html>
