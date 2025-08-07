<?php include 'db.php'; ?>
<?php
$id = $_GET['id'];
$conn->query("DELETE FROM booking WHERE id=$id");
header("Location: booking.php");
?>
