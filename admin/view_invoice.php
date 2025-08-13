<?php
// Database connection
$servername = "localhost";
$username = "root"; // your MySQL username
$password = ""; // your MySQL password
$dbname = "showroom"; // your database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is given
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid invoice ID.");
}

$invoice_id = intval($_GET['id']);

// Fetch invoice
$sql = "SELECT * FROM invoices WHERE id = $invoice_id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die("Invoice not found.");
}

$invoice = $result->fetch_assoc();
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?php echo htmlspecialchars($invoice['invoice_no']); ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { margin-bottom: 10px; }
        table { border-collapse: collapse; width: 60%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <h1>Invoice #<?php echo htmlspecialchars($invoice['invoice_no']); ?></h1>
    <p><strong>Bill To:</strong> <?php echo htmlspecialchars($invoice['bill_to']); ?></p>
    <p><strong>Ship To:</strong> <?php echo htmlspecialchars($invoice['ship_to']); ?></p>
    <p><strong>Date:</strong> <?php echo htmlspecialchars($invoice['date']); ?></p>
    <p><strong>Due Date:</strong> <?php echo htmlspecialchars($invoice['due_date']); ?></p>
    <p><strong>PO Number:</strong> <?php echo htmlspecialchars($invoice['po_number']); ?></p>
    <hr>
    <h3>Amounts</h3>
    <table>
        <tr><th>Subtotal</th><td><?php echo number_format($invoice['subtotal'], 2); ?></td></tr>
        <tr><th>Tax</th><td><?php echo number_format($invoice['tax'], 2); ?></td></tr>
        <tr class="total"><th>Total</th><td><?php echo number_format($invoice['total'], 2); ?></td></tr>
        <tr><th>Amount Paid</th><td><?php echo number_format($invoice['amount_paid'], 2); ?></td></tr>
        <tr class="total"><th>Balance Due</th><td><?php echo number_format($invoice['balance_due'], 2); ?></td></tr>
    </table>
    <hr>
    <h3>Notes</h3>
    <p><?php echo nl2br(htmlspecialchars($invoice['notes'])); ?></p>
    <h3>Terms</h3>
    <p><?php echo nl2br(htmlspecialchars($invoice['terms'])); ?></p>
</body>
</html>
