<?php include 'dashboard.php'; ?>include 
<?php include 'db.php'; ?> <!-- Make sure DB connection is included -->

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $carname = $_POST['carname'];
    $engine  = $_POST['engine'];
    $model   = $_POST['model'];
    $price   = $_POST['price'];

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
        $stmt = $conn->prepare("INSERT INTO cars (name, engine_cc, model, price, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $carname, $engine, $model, $price, $imageName);
        $stmt->execute();

        header("Location: cars.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>❌ Failed to upload image. Please check permissions of /uploads folder.</div>";
    }
}
?>

<!-- HTML Form -->
<div class="main-content p-4">
    <h2>Add Car</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <input type="text" name="carname" class="form-control" placeholder="Car Name" required>
        </div>
        <div class="mb-3">
                         <select name="engine" class="form-control">
                        <option value="">select option</option>
                        <option value="800cc">800cc</option>
                        <option value="1000cc">1000cc</option>
                        <option value="1300cc">1300cc</option>
                        <option value="1500cc">1500cc</option>
                        <option value="1800cc">1800cc</option>
                        <option value="2000cc">2000cc</option>
                        <option value="2800cc">2800cc</option>
                        <option value="3500cc">3500cc</option>

        </div>
        <div class="mb-3">
            <input type="text" name="model" class="form-control" placeholder="Model" required>
        </div>
        <div class="mb-3">
            <input type="text" name="price" class="form-control" placeholder="Price" required>
        </div>
        <div class="mb-3">
            <input type="file" name="image" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-success">Add Car</button>
        <a href="cars.php" class="btn btn-secondary">Back</a>
    </form>
</div>
