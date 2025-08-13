<?php include 'dashboard.php'; ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $username= $_POST['username'];
    $name= $_POST['name'];
    $email= $_POST['email'];
    $password= $_POST['password'];
    $role= $_POST['role'];
    
    $conn->query("INSERT INTO users (username, name, email, password, role) VALUES ('$username', '$name', '$email', '$password', '$role')");
    header("Location: users.php");
}
?>
<div class="main-content">
    <h2>Add User</h2>
    <form method="POST">
        <div class="mb-3"><input type="text" name="username"class="form-control"placeholder="username"required></div>
        <div class="mb-3"><input type="text" name="name"class="form-control"placeholder="name"required></div>
        <div class="mb-3"><input type="text" name="email"class="form-control"placeholder="email"required></div>
        <div class="mb-3"><input type="text" name="password"class="form-control"placeholder="password"required></div>
        <div class="mb-3"><input type="text" name="role"class="form-control"placeholder="role"required></div>
        <button type="submit" class="btn btn-success">Add</button>
        <a href="users.php" class="btn btn-secondary">Back</a>
    </form>
</div>
