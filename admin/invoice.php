<?php
include 'db.php';

if (!isset($_GET['id'])) {
    die("No invoice ID provided.");
}

$id = intval($_GET['id']);

// Get invoice details
$invoice = $conn->query("SELECT * FROM invoices WHERE id = $id")->fetch_assoc();

// Get invoice items
$items = $conn->query("SELECT * FROM invoice_items WHERE invoice_id = $id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Invoice #<?php echo $invoice['id']; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <h2>Invoice #<?php echo $invoice['id']; ?></h2>
    <p><strong>Date:</strong> <?php echo $invoice['date']; ?></p>
    <p><strong>Customer:</strong> <?php echo $invoice['name']; ?></p>
    <p><strong>Type:</strong> <?php echo $invoice['types']; ?></p>
    <p><strong>Payment:</strong> <?php echo $invoice['pay_type']; ?></p>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $grand_total = 0;
        while ($row = $items->fetch_assoc()) {
            $total = $row['quantity'] * $row['price'];
            $grand_total += $total;
            echo "<tr>
                <td>{$row['product_name']}</td>
                <td>{$row['quantity']}</td>
                <td>{$row['price']}</td>
                <td>{$total}</td>
            </tr>";
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Grand Total</th>
                <th><?php echo $grand_total; ?></th>
            </tr>
        </tfoot>
    </table>

    <button onclick="window.print()" class="btn btn-primary">Print</button>
</body>
</html>
