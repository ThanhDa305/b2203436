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

$sql = "INSERT INTO major (id,name_major) VALUES

('".$_POST["id"] ."','".$_POST["name_major"] ."')";

if ($conn->query($sql) == TRUE) {
echo "Them sinh vien thanh cong";
//neu thuc hien thanh cong, chung ta se cho di chuyen den
// taidulieu_bang.php
header('Location: major_index.php');
} else {
echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>