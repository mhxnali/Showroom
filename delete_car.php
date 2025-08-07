<?php include 'db.php'; ?>
<?php
$id = $_GET['id'];
$conn->query("DELETE FROM cars WHERE id=$id");
header("Location: cars.php");
?>
