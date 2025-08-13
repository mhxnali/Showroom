<?php
include 'dashboard.php';
include 'db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM invoices WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $name = $_POST['name'];
    $types = $_POST['types'];
    $pay_type = $_POST['pay_type'];
    $price = $_POST['price'];

    $sql = "UPDATE invoices 
            SET date='$date', name='$name', types='$types', pay_type='$pay_type', price='$price' 
            WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: sales.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<div class="main-content">
    <h2>Edit Invoice</h2>
    <form method="POST">
        <div class="form-group">
            <label>Date</label>
            <input type="date" name="date" class="form-control" value="<?php echo $row['date']; ?>" required>
        </div>
        <div class="form-group">
            <label>Customer Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>" required>
        </div>
        <div class="form-group">
            <label>Type</label>
            <input type="text" name="types" class="form-control" value="<?php echo $row['types']; ?>" required>
        </div>
        <div class="form-group">
            <label>Payment Method</label>
            <input type="text" name="pay_type" class="form-control" value="<?php echo $row['pay_type']; ?>" required>
        </div>
        <div class="form-group">
            <label>Price (PKR)</label>
            <input type="number" name="price" class="form-control" value="<?php echo $row['price']; ?>" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Update Invoice</button>
    </form>
</div>
