<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $imageName = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($ext, $allowed)) {
            $imageName = uniqid() . '.' . $ext;
            $uploadPath = '../uploads/' . $imageName;
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath);
        }
    }

    $stmt = $conn->prepare("INSERT INTO services (name, category, description, price, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssds", $name, $category, $description, $price, $imageName);
    $stmt->execute();
    $stmt->close();

    header("Location: services.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h2>Add New Service</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Category</label>
            <input type="text" name="category" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Price (PKR)</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Image (.jpg, .jpeg, .png, .gif)</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Save Service</button>
    </form>
</div>
</body>
</html>
