<?php
// db.php - sample. Replace credentials if needed.
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "showroom";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
