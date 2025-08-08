<?php include 'dashboard.php'; ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db.php';

    $date = $_POST['date'];
    $name = $_POST['name'];
    $types = $_POST['types'];
    $pay_type = $_POST['pay_type'];

    // Insert into invoices table
    $conn->query("INSERT INTO invoices (date, name, types, pay_type) VALUES ('$date', '$name', '$types', '$pay_type')");
    $invoice_id = $conn->insert_id;

    // Insert products into invoice_items table
    foreach ($_POST['product'] as $index => $product) {
        $price = $_POST['price'][$index];
        $qty = $_POST['qty'][$index];
        $conn->query("INSERT INTO invoice_items (invoice_id, product, price, qty) 
                      VALUES ('$invoice_id', '$product', '$price', '$qty')");
    }

    header("Location: invoice.php?id=$invoice_id");
}
?>
<div class="main-content">
    <h2>Add Invoice</h2>
    <form method="POST">
        <div class="mb-3"><input type="date" name="date" class="form-control" required></div>
        <div class="mb-3"><input type="text" name="name" class="form-control" placeholder="Customer Name" required></div>
        <div class="mb-3">
            <select name="types" class="form-control" required>
                <option value="">Select Type</option>
                <option value="auto parts">Auto Parts</option>
                <option value="car booking">Car Booking</option>
                <option value="car delivery">Car Delivery</option>
                <option value="car service">Car Service</option>
                <option value="car insurance">Car Insurance</option>
            </select>
        </div>

        <h4>Products</h4>
        <div id="product-list">
            <div class="row mb-2">
                <div class="col"><input type="text" name="product[]" class="form-control" placeholder="Product" required></div>
                <div class="col"><input type="number" step="0.01" name="price[]" class="form-control" placeholder="Price" required></div>
                <div class="col"><input type="number" name="qty[]" class="form-control" placeholder="Qty" required></div>
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-info" onclick="addProduct()">+ Add Product</button>

        <div class="mb-3 mt-3">
            <select name="pay_type" class="form-control" required>
                <option value="">Select Payment Method</option>
                <option value="Cash">Cash</option>
                <option value="Credit Card">Credit Card</option>
                <option value="Debit Card">Debit Card</option>
                <option value="Online Banking">Online Banking</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Generate Invoice</button>
        <a href="sales.php" class="btn btn-secondary">Back</a>
    </form>
</div>

<script>
function addProduct() {
    let div = document.createElement('div');
    div.classList.add('row', 'mb-2');
    div.innerHTML = `
        <div class="col"><input type="text" name="product[]" class="form-control" placeholder="Product" required></div>
        <div class="col"><input type="number" step="0.01" name="price[]" class="form-control" placeholder="Price" required></div>
        <div class="col"><input type="number" name="qty[]" class="form-control" placeholder="Qty" required></div>
    `;
    document.getElementById('product-list').appendChild(div);
}
</script>
