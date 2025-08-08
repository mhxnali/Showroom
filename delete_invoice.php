<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // Delete invoice and related items
    $conn->query("DELETE FROM invoices WHERE id = $id");
}

header("Location: sales.php");
exit;
