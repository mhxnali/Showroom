<?php include 'db.php'; ?>
<?php
$id = $_GET['id'];
$conn->query("DELETE FROM users WHERE id=$id");
header("Location: users.php");
?>
