<?php include 'dashboard.php'; ?>
<?php
$id = $_GET['id'];
$row = $conn->query("SELECT * FROM spare_parts WHERE id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $category= $_POST['category'];
    $price= $_POST['price'];
    $stock= $_POST['stock'];
    $image= $_POST['image'];
    $conn->query("UPDATE spare_parts SET name='$name', category='$category', price='$price', stock='$stock', image='$image' WHERE id=$id");
    header("Location: spare_parts.php");
}
?>
<div class="main-content">
    <h2>Edit Spare Part</h2>
    <form method="POST">
        <div class="mb-3"><input type="text" name="name" value="<?= $row['name'] ?>" class="form-control" required></div>    
        <div class="mb-3"><input type="text" name="category" value="<?= $row['category'] ?>" class="form-control" required></div>       
        <div class="mb-3"><input type="text" name="price" value="<?= $row['price'] ?>" class="form-control" required></div>       
        <div class="mb-3"><input type="text" name="stock" value="<?= $row['stock'] ?>" class="form-control" required></div>       
        <div class="mb-3"><input type="text" name="image" value="<?= $row['image'] ?>" class="form-control" required></div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="spare_part.php" class="btn btn-secondary">Back</a>
    </form>
</div>
