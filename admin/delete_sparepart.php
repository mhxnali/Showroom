<?php include 'db.php'; ?>
<?php
$id = $_GET['id'];
$conn->query("DELETE FROM spare_parts WHERE id=$id");
header("Location: spare_parts.php");
?>
