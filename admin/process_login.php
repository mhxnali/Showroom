<?php
session_start();

// DB connection settings
$host = "localhost";
$db = "showroom";
$user = "root";      // use your DB username
$pass = "";          // use your DB password

// Connect to MySQL
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // NOTE: Use password_verify() if using hashed passwords
        if ($password === $user['password']) {
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");
            exit();
        }
    }

    header("Location: index.php?error=Invalid+username+or+password");
    exit();
}

$conn->close();
