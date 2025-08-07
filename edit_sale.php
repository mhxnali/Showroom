<?php include 'dashboard.php'; ?>
<?php
$id = $_GET['id'];
$row = $conn->query("SELECT * FROM sales WHERE id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date= $_POST['date'];
    $name= $_POST['name'];
    $types= $_POST['types'];
    $product= $_POST['product'];
    $price= $_POST['price'];
    $pay_type= $_POST['pay_type'];
    $conn->query("UPDATE sales SET date='$date', name='$name',types='$types', product='$product', price='$price', pay_type='$pay_type' WHERE id=$id");
    header("Location: sales.php");
}
?>
<div class="main-content">
    <h2>Edit Sales</h2>
    <form method="POST">
        <div class="mb-3"><input type="text" name="date" value="<?= $row['date'] ?>" class="form-control" required></div>    
        <div class="mb-3"><input type="text" name="name" value="<?= $row['name'] ?>" class="form-control" required></div>       
        <div class="mb-3"><input type="text" name="types" value="<?= $row['types'] ?>" class="form-control" required></div>       
        <div class="mb-3"><input type="text" name="product" value="<?= $row['product'] ?>" class="form-control" required></div>       
        <div class="mb-3"><input type="text" name="price" value="<?= $row['price'] ?>" class="form-control" required></div>
        <div class="mb-3"><input type="text" name="pay_type" value="<?= $row['pay_type'] ?>" class="form-control" required></div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="sales.php" class="btn btn-secondary">Back</a>
    </form>
</div>
