<?php include 'dashboard.php'; ?>
<?php include 'db.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST['name'];
    $category = $_POST['category'];
    $price    = $_POST['price'];
    $stock    = $_POST['stock'];

    // Handle image upload
    $imageName = $_FILES['image']['name'];
    $imageTmp  = $_FILES['image']['tmp_name'];
    $uploadDir = "uploads/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $imagePath = $uploadDir . basename($imageName);

    if (move_uploaded_file($imageTmp, $imagePath)) {
        // Save record in database
        $stmt = $conn->prepare("INSERT INTO spare_parts (name, category, price, stock, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis", $name, $category, $price, $stock, $imageName);

        if ($stmt->execute()) {
            header("Location: spare_parts.php?msg=added");
            exit;
        } else {
            echo "<div class='alert alert-danger'>❌ Failed to add spare part.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>❌ Image upload failed. Please check /uploads/ folder permissions.</div>";
    }
}
?>

<div class="main-content p-4">
    <h2>Add Spare Part</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <input type="text" name="name" class="form-control" placeholder="Part Name" required>
        </div>
        
        <div class="mb-3">
            <select name="category" class="form-control" required>
                <option value="">-- Select Category --</option>
                <option value="Mechanical">Mechanical</option>
                <option value="Exterior">Exterior</option>
                <option value="Interior">Interior</option>
                <option value="Electrical">Electrical</option>
                <option value="Other">Other</option>
            </select>
        </div>
        
        <div class="mb-3">
            <input type="number" name="price" class="form-control" placeholder="Price" required>
        </div>
        
        <div class="mb-3">
            <input type="number" name="stock" class="form-control" placeholder="Stock Quantity" required>
        </div>
        
        <div class="mb-3">
            <input type="file" name="image" class="form-control" accept="image/*" required>
        </div>
        
        <button type="submit" class="btn btn-success">Add Spare Part</button>
        <a href="spare_parts.php" class="btn btn-secondary">Back</a>
    </form>
</div>
