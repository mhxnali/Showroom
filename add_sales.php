<?php include 'dashboard.php'; ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date= $_POST['date'];
    $name= $_POST['name'];
    $types= $_POST['types'];
    $product= $_POST['product'];
    $price= $_POST['price'];
    $pay_type= $_POST['pay_type'];
    $conn->query("INSERT INTO sales (date, name, types, product, price, pay_type) VALUES ('$date', '$name', '$types', '$product', '$price', '$pay_type')");
    header("Location:sales.php");
}
?>
<div class="main-content">
    <h2>Add Sales</h2>
    <form method="POST">
        <div class="mb-3"><input type="text" name="date"class="form-control" placeholder="date"required></div>
        <div class="mb-3"><input type="text" name="name"class="form-control" placeholder="name"required></div>
        <div class="mb-3"><input type="text" name="types"class="form-control" placeholder="types"required></div>
        <div class="mb-3"><input type="text" name="product"class="form-control" placeholder="product"required></div>
        <div class="mb-3"><input type="text" name="price"class="form-control" placeholder="price"required></div>
        <div class="mb-3"><input type="text" name="pay_type"class="form-control" placeholder="pay_type"required></div>
        <button type="submit" class="btn btn-success">Add</button>
        <a href="sales.php" class="btn btn-secondary">Back</a>
    </form>
</div>
