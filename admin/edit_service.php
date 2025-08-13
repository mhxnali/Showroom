<?php
include 'db.php';

// Get service ID from URL
$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    die("Invalid service ID.");
}

// Fetch service from DB
$result = mysqli_query($conn, "SELECT * FROM services WHERE id=$id");
$service = mysqli_fetch_assoc($result);
if (!$service) {
    die("Service not found.");
}

// Handle update on form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = mysqli_real_escape_string($conn, $_POST['name']);
    $category    = mysqli_real_escape_string($conn, $_POST['category']);
    $price       = floatval($_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $imageName = $service['image']; // Keep old image unless replaced

    // If new image uploaded
    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp'];

        if (in_array($ext, $allowed)) {
            $uploadDir = '../uploads/services/';

            // Delete old image
            if (!empty($service['image']) && file_exists($uploadDir . $service['image'])) {
                unlink($uploadDir . $service['image']);
            }

            // Save new image
            $imageName = time() . '_' . bin2hex(random_bytes(5)) . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);
        }
    }

    // Update DB
    $update = "UPDATE services SET 
                name='$name',
                category='$category',
                price='$price',
                description='$description',
                image='$imageName'
               WHERE id=$id";

    if (mysqli_query($conn, $update)) {
        header("Location: services.php?msg=updated");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
    <h2 class="mb-4">Edit Service</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Service Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($service['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($service['category']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Price (PKR)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?= htmlspecialchars($service['price']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($service['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Current Image</label><br>
            <?php if (!empty($service['image']) && file_exists("../uploads/services/" . $service['image'])): ?>
                <img src="../uploads/services/<?= htmlspecialchars($service['image']) ?>" style="width:120px;height:90px;object-fit:cover;border:1px solid #ddd;padding:3px;">
            <?php else: ?>
                <p>No image uploaded.</p>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Change Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Update Service</button>
        <a href="services.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>
