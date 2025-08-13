<?php
include 'dashboard.php';
$id = $_GET['id'];
$row = $conn->query("SELECT * FROM cars WHERE id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $model = $_POST['model'];
    $engine_cc = $_POST['engine_cc'];
    $price = $_POST['price'];
    $imageName = $row['image']; // Use existing image by default

    // If new image is uploaded
    if (!empty($_FILES['image']['name'])) {
        $imageName = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $uploadDir = "uploads/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $imagePath = $uploadDir . basename($imageName);

        if (!move_uploaded_file($imageTmp, $imagePath)) {
            echo "<div class='alert alert-danger'>❌ Failed to upload image.</div>";
            exit;
        }
    }

    // Update record (with or without new image)
    $stmt = $conn->prepare("UPDATE cars SET name=?, engine_cc=?, model=?, price=?, image=? WHERE id=?");
    $stmt->bind_param("sssssi", $name, $engine_cc, $model, $price, $imageName, $id);

    if ($stmt->execute()) {
        header("Location: cars.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>❌ Failed to update car.</div>";
    }
}
?>


<div class="main-content">
    <h2>Edit Car</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <input type="text" name="name" value="<?= $row['name'] ?>" class="form-control" required>
        </div>    
        <div class="mb-3">
            <input type="text" name="model" value="<?= $row['model'] ?>" class="form-control" required>
        </div>       
        <div class="mb-3">
            <input type="text" name="engine_cc" value="<?= $row['engine_cc'] ?>" class="form-control" required>
        </div>       
        <div class="mb-3">
            <input type="text" name="price" value="<?= $row['price'] ?>" class="form-control" required>
        </div>

        <!-- Do not use "value" on file input -->
        <div class="mb-3">
            <label>Upload New Image (optional):</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <?php if (!empty($row['image'])): ?>
                <p>Current Image:</p>
                <img src="uploads/<?= $row['image'] ?>" width="120">
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="cars.php" class="btn btn-secondary">Back</a>
    </form>
</div>
