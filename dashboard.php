<!-- dashboard.php -->
<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 56px;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            padding: 12px 20px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            margin-left: 250px;
            margin-top: 56px;
            padding: 20px;
        }
    </style>
</head>
<body>

<!-- Top Navbar -->
<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">🚗 Showroom</a>
        <div class="d-flex">
            <a class="nav-link text-light" href="#">Profile</a>
            <a class="nav-link text-danger" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidebar">
    <a href="dashboard.php">Dashboard</a>
    <a href="users.php">Manage Users</a>
    <a href="#">Cars</a>
    <a href="#">Sales</a>
    <a href="logout.php" class="text-danger">Logout</a>
</div>
