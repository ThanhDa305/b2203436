<?php
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

// Kiểm tra xem có tệp nào đã được upload không
if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] == 0) {
    // Kiểm tra loại tệp
    $fileType = pathinfo($_FILES['csvFile']['name'], PATHINFO_EXTENSION);
    if ($fileType != 'csv') {
        die("Chỉ chấp nhận tệp CSV.");
    }

    // Mở tệp và đọc nội dung
    if (($handle = fopen($_FILES['csvFile']['tmp_name'], 'r')) !== FALSE) {
        // Bỏ qua dòng tiêu đề
        fgetcsv($handle);

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $fullname = $conn->real_escape_string($data[0]);
            $email = $conn->real_escape_string($data[1]);
            $birthday = $conn->real_escape_string($data[2]);
            $password = md5($conn->real_escape_string($data[3]));

            // Chèn dữ liệu vào bảng customers
            $sql = "INSERT INTO customers (fullname, email, birthday, password) VALUES ('$fullname', '$email', '$birthday', '$password')";
            $conn->query($sql);
        }
        fclose($handle);
        echo "Dữ liệu đã được upload thành công!";
    } else {
        echo "Không thể mở tệp.";
    }
} else {
    echo "Không có tệp nào được upload.";
}

// Đóng kết nối
$conn->close();
?>
