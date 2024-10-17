<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qlsv";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy dữ liệu từ bảng major
$sql = "SELECT * FROM major";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Load dữ liệu mới lên vào biến result
    $result_all = $result->fetch_all(MYSQLI_ASSOC);
    
    // Tiêu đề bảng
    echo "<h1>Bảng dữ liệu chuyên ngành</h1>";
    echo "<table border=1><tr><th>ID</th><th>Tên chuyên ngành</th><th colspan='2'>Hành động</th></tr>";
    
    // Hiển thị dữ liệu của từng dòng
    foreach ($result_all as $row) {
        echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["name_major"] . "</td>
                <td>";
        ?>
        <!-- Form để thực hiện xóa chuyên ngành -->
        <form method="post" action="major_delete.php">
            <input type="submit" name="action" value="xoa"/>
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>"/>
        </form>
        <?php
        echo "</td><td>";
        ?>
        <!-- Form để thực hiện sửa chuyên ngành -->
        <form method="post" action="major_edit.php">
            <input type="submit" name="action" value="sua"/>
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>"/>
        </form>
        <?php
        echo "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 kết quả trả về";
}

$conn->close();
?>