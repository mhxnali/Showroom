<?php include 'db.php'; ?>
<?php
$id = $_GET['id'];
$conn->query("DELETE FROM sales WHERE id=$id");
header("Location: sales.php");
?>
