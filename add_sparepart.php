<?php include 'dashboard.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name= $_POST['name'];
    $category= $_POST['category'];
    $price= $_POST['price'];
    $stock= $_POST['stock'];
    $image= $_POST['image'];
   
   // Handle image upload
    $imageName = $_FILES['image']['name'];
    $imageTmp  = $_FILES['image']['tmp_name'];
    $uploadDir = "uploads/";

    // Create uploads directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $imagePath = $uploadDir . basename($imageName);

    if (move_uploaded_file($imageTmp, $imagePath)) {
        // Upload successful
        // Save everything to database
        $stmt = $conn->prepare("INSERT INTO spare_parts  (name, category, price, stock, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $category, $price, $stock, $imageName);
        $stmt->execute();

        header("Location: spare_parts.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>❌ Failed to upload image. Please check permissions of /uploads folder.</div>";
    }
}
?> 
<!-- HTML Form -->

<div class="main-content" p-4>
    <h2>Add Spare Parts</h2>
    <form method="POST" enctype="multipart/form-data">
       <div class="mb-3">
           <input type="text" name="name"class="form-control" placeholder="name" required>
    </div>
        <div class="mb-3">
            <select name="category" class="form-control">
                <option value="">select option</option>
                <option value="interior">interior</option>
                <option value="exterior">exterior</option>
                <option value="mechanical">mechanical</option>


            </select>
    </div>
        <div class="mb-3">
             <input type="text" name="price"class="form-control" placeholder="price" required> 
    </div>
         <div class="mb-3">
               <input type="text" name="stock"class="form-control" placeholder="stock" required>
    </div>
          <div class="mb-3">
              <input type="file" name="image"class="form-control" accept="image" required>
    </div>
        <button type="submit" class="btn btn-success">Add</button>
        <a href="spare_parts.php" class="btn btn-secondary">Back</a>
    </form>
</div>
