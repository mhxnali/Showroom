<?php
include 'db.php';

if (!isset($_GET['id'])) {
    die("No spare part ID provided.");
}

$id = $_GET['id'];

// Delete the part
$sql = "DELETE FROM spare_parts WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    header("Location: spare_parts.php?msg=deleted");
    exit;
} else {
    echo "Error deleting part: " . mysqli_error($conn);
}
?>
