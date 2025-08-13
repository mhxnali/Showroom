<?php include 'db.php'; ?>
<?php
$id = $_GET['id'];
$conn->query("DELETE FROM Customer WHERE id=$id");
header("Location: Customer.php");
?>
