<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Simple login check (Replace with database authentication later)
    if ($username === "admin" && $password === "1234") {
        $_SESSION['logged_in'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login - Showroom</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- Navbar -->
<?php include 'navbar.php'; ?>

<!-- Login Form -->
<section class="login-section">
    <h1>Login</h1>
    <?php if (!empty($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form method="post" action="">
        <label>Username</label>
        <input type="text" name="username" required>
        
        <label>Password</label>
        <input type="password" name="password" required>
        
        <button type="submit">Sign In</button>
    </form>
</section>

<!-- Footer -->
<?php include 'footer.php'; ?>

</body>
</html>
