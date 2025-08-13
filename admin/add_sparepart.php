<?php
include 'dashboard.php';
include 'db.php';

// Fetch spare parts for dropdown
$products = $conn->query("SELECT id, name, category, price FROM spare_parts");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $name = $_POST['name'];
    $product_id = $_POST['product_id'];
    $pay_type = $_POST['pay_type'];
    $price = $_POST['price'];

    // Get product name for saving in invoice
    $product_res = $conn->query("SELECT name FROM spare_parts WHERE id='$product_id'");
    $product_row = $product_res->fetch_assoc();
    $product_name = $product_row['name'];

    $sql = "INSERT INTO invoices (date, name, types, pay_type, price) 
            VALUES ('$date', '$name', '$product_name', '$pay_type', '$price')";
    if ($conn->query($sql) === TRUE) {
        header("Location: sales.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<div class="main-content">
    <h2>Add Invoice</h2>
    <form method="POST">
        <div class="form-group">
            <label>Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Customer Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        
        <!-- Product Dropdown -->
        <div class="form-group">
            <label>Select Product</label>
            <select name="product_id" id="product_id" class="form-control" required>
                <option value="">-- Select Product --</option>
                <?php while ($row = $products->fetch_assoc()) { ?>
                    <option value="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>">
                        <?= $row['name'] ?> (<?= $row['category'] ?>)
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label>Payment Method</label>
            <input type="text" name="pay_type" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Price (PKR)</label>
            <input type="number" name="price" id="price" class="form-control" required>
        </div>
        
        <br>
        <button type="submit" class="btn btn-success">Save Invoice</button>
    </form>
</div>

<!-- Auto-fill price when product changes -->
<script>
document.getElementById('product_id').addEventListener('change', function() {
    var selected = this.options[this.selectedIndex];
    var price = selected.getAttribute('data-price');
    document.getElementById('price').value = price || '';
});
</script>
