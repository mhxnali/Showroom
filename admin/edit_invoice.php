<?php
// edit_invoice.php
include 'db.php';

// Get invoice ID from URL
$id = $_GET['id'] ?? null;

if (!$id) {
    die("Invoice ID not provided.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = $_POST['customer_name'] ?? '';
    $product = $_POST['product'] ?? '';
    $quantity = $_POST['quantity'] ?? 0;
    $price = $_POST['price'] ?? 0;

    $stmt = $conn->prepare("UPDATE invoices SET customer_name=?, product=?, quantity=?, price=? WHERE id=?");
    $stmt->bind_param("ssidi", $customer_name, $product, $quantity, $price, $id);

    if ($stmt->execute()) {
        header("Location: invoices_list.php?updated=1");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch current invoice details
$stmt = $conn->prepare("SELECT * FROM invoices WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$invoice = $result->fetch_assoc();

if (!$invoice) {
    die("Invoice not found.");
}

$stmt->close();
?>

<!-- Simple Form to Edit Invoice -->
<form action="edit_invoice.php?id=<?php echo $id; ?>" method="POST">
    <label>Customer Name:</label>
    <input type="text" name="customer_name" value="<?php echo htmlspecialchars($invoice['customer_name']); ?>" required><br>

    <label>Product:</label>
    <input type="text" name="product" value="<?php echo htmlspecialchars($invoice['product']); ?>" required><br>

    <label>Quantity:</label>
    <input type="number" name="quantity" value="<?php echo htmlspecialchars($invoice['quantity']); ?>" required><br>

    <label>Price:</label>
    <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($invoice['price']); ?>" required><br>

    <button type="submit">Update Invoice</button>
</form>
