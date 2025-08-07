<?php
include 'db.php';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=spare_parts_inventory.csv');

// Open output stream
$output = fopen('php://output', 'w');

// Output column headings
fputcsv($output, ['ID', 'Name', 'Brand', 'Category', 'Price', 'Quantity', 'Description']);

// Fetch and output rows
$result = mysqli_query($conn, "SELECT * FROM spare_parts");

while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, [
        $row['id'],
        $row['name'],
        $row['brand'],
        $row['category'],
        $row['price'],
        $row['quantity'],
        $row['description']
    ]);
}

fclose($output);
?>
