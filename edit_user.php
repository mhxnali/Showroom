<?php include 'dashboard.php'; ?>
<?php
$id = $_GET['id'];
$row = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $conn->query("UPDATE users SET name='$name', email='$email' WHERE id=$id");
    header("Location: users.php");
}
?>
<div class="main-content">
    <h2>Edit User</h2>
    <form method="POST">
        <div class="mb-3"><input type="text" name="name" value="<?= $row['name'] ?>" class="form-control" required></div>
        <div class="mb-3"><input type="email" name="email" value="<?= $row['email'] ?>" class="form-control" required></div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="users.php" class="btn btn-secondary">Back</a>
    </form>
</div>
