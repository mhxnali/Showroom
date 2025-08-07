<?php include 'dashboard.php'; ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name= $_POST['name'];
    $category= $_POST['category'];
    $price= $_POST['price'];
    $stock= $_POST['stock'];
    $image= $_POST['image'];
   

    $conn->query("INSERT INTO spare_parts (name, category, price,stock,image) VALUES ('$name', '$category', '$price', '$stock', '$image')");
    header("Location: spare_parts.php");
}
?>
<div class="main-content">
    <h2>Add Spare Parts</h2>
    <form method="POST">
       <div class="mb-3"><input type="text" name="name"class="form-control" placeholder="name" required></div>
        <div class="mb-3"><input type="text" name="category"class="form-control" placeholder="category" required></div>
        <div class="mb-3"><input type="text" name="price"class="form-control" placeholder="price" required></div>
         <div class="mb-3"><input type="text" name="stock"class="form-control" placeholder="stock" required></div>
          <div class="mb-3"><input type="text" name="image"class="form-control" placeholder="image" required></div>
        <button type="submit" class="btn btn-success">Add</button>
        <a href="spare_parts.php" class="btn btn-secondary">Back</a>
    </form>
</div>
