<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Modern Professional Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif !important;
            font-size: 15px;
            color: #212529;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            background-size: 400% 400%;
            animation: gradientShift 20s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 56px;
            left: 0;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 20px;
            box-shadow: 4px 0 12px rgba(0,0,0,0.2);
        }
        .sidebar a {
            color: #f1f1f1;
            padding: 12px 20px;
            display: block;
            text-decoration: none;
            font-weight: 500;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
        }
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(6px);
            border-radius: 8px;
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 18px;
            color: #fff !important;
            letter-spacing: 0.5px;
        }

        .main-content {
            margin-left: 250px;
            margin-top: 56px;
            padding: 25px;
            font-size: 15px;
            color: #f5f5f5;
            animation: fadeIn 0.8s ease-in-out;
        }

        h3 {
            font-weight: 600;
            color: #ffffff;
            text-shadow: 0 1px 4px rgba(0,0,0,0.3);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Navbar link hover effect */
        .navbar-nav .nav-link {
            transition: color 0.3s ease, transform 0.2s ease;
        }
        .navbar-nav .nav-link:hover {
            color: #f8c146 !important;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<!-- Updated Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm" style="backdrop-filter: blur(12px); background: rgba(0, 0, 0, 0.6); border-bottom: 1px solid rgba(255,255,255,0.15);">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand fw-bold" href="#">Showroom Dashboard</a>

        <!-- Toggler for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#dashboardNavbar" aria-controls="dashboardNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="dashboardNavbar">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link text-light" href="#">Profile</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidebar">
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="cars.php">🚗 Cars</a>
    <a href="spare_parts.php">🛠️ Spare Parts</a>
    <a href="Customer.php">👥 Customer</a>
    <a href="sales.php">💰 Sales</a>
    <a href="users.php">👥 Manage Users</a>
    <a href="booking.php">📞 Booking</a>
    <a href="services.php">🛎️ Services</a>
    <a href="reports.php">📊 Reports</a>
    <a href="logout.php" class="text-danger">🚪 Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">
    <?php
        $page = $_GET['page'] ?? '';
        switch ($page) {
            case 'car_600': include 'pages/car_600.php'; break;
            case 'car_800': include 'pages/car_800.php'; break;
            case 'car_1000': include 'pages/car_1000.php'; break;
            case 'car_1300': include 'pages/car_1300.php'; break;
            case 'car_1500': include 'pages/car_1500.php'; break;
            case 'car_2000': include 'pages/car_2000.php'; break;
            case 'car_3500': include 'pages/car_3500.php'; break;
            default: echo "<h3>Welcome to Showroom Dashboard</h3>";
        }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
