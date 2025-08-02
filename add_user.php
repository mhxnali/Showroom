<?php include 'dashboard.php'; ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $conn->query("INSERT INTO users (name, email) VALUES ('$name', '$email')");
    header("Location: users.php");
}
?>
<div class="main-content">
    <h2>Add User</h2>
    <form method="POST">
        <div class="mb-3"><input type="text" name="name" class="form-control" placeholder="Name" required></div>
        <div class="mb-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
        <button type="submit" class="btn btn-success">Add</button>
        <a href="users.php" class="btn btn-secondary">Back</a>
    </form>
</div>
