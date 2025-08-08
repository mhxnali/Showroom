<?php
include 'db.php';

if (!isset($_GET['id'])) {
    die("No invoice ID provided.");
}

$id = intval($_GET['id']);
$invoice_sql = "SELECT * FROM invoices WHERE id = $id";
$invoice = $conn->query($invoice_sql)->fetch_assoc();

$items_sql = "SELECT * FROM invoice_items WHERE invoice_id = $id";
$items = $conn->query($items_sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Invoice #<?php echo $invoice['id']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .invoice-box { max-width: 800px; margin: auto; padding: 20px; border: 1px solid #eee; }
        .invoice-title { font-size: 28px; font-weight: bold; text-align: center; }
    </style>
</head>
<body>
<div class="invoice-box">
    <div class="invoice-title">SALE INVOICE</div>
    <hr>
    <p><strong>Invoice #:</strong> <?php echo $invoice['id']; ?></p>
    <p><strong>Date:</strong> <?php echo $invoice['date']; ?></p>
    <p><strong>Customer Name:</strong> <?php echo $invoice['name']; ?></p>
    <p><strong>Type:</strong> <?php echo $invoice['types']; ?></p>
    <p><strong>Payment Method:</strong> <?php echo $invoice['pay_type']; ?></p>
    <hr>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $grand_total = 0;
            while ($row = $items->fetch_assoc()) {
                $total = $row['price'] * $row['qty'];
                $grand_total += $total;
                echo "<tr>
                    <td>{$row['product']}</td>
                    <td>".number_format($row['price'], 2)."</td>
                    <td>{$row['qty']}</td>
                    <td>".number_format($total, 2)."</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
    <h4 class="text-end">Grand Total: <?php echo number_format($grand_total, 2); ?></h4>
    <div class="text-center mt-3">
        <button onclick="window.print()" class="btn btn-primary">Print Invoice</button>
    </div>
</div>
</body>
</html>
