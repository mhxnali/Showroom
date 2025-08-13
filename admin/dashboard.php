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

        /* Dark Mode Styles */
        .dark-mode {
            background-color: #121212 !important;
            color: #f1f1f1 !important;
        }
        .dark-mode .card {
            background-color: #1e1e1e;
            border: 1px solid #333;
        }
        .dark-mode .sidebar {
            background-color: #212529;
        }
        .dark-mode .sidebar a {
            color: #f8f9fa;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid d-flex justify-content-between">
        <a class="navbar-brand" href="#">🚘 Showroom</a>

        <div class="d-flex align-items-center gap-2">
            <!-- 🌙 Dark Mode Button -->
            <button class="btn btn-outline-light btn-sm" onclick="toggleDarkMode()">🌙 Dark Mode</button>

            <!-- 🌐 Language Selector -->
            <select class="form-select form-select-sm bg-dark text-light border-light" style="width: auto;" onchange="setLanguage(this.value)">
                <option value="en">🌐 English</option>
                <option value="ur">🇵🇰 Urdu</option>
            </select>

            <!-- Profile & Logout -->
            <a class="nav-link text-light" href="#">Profile</a>
            <a class="nav-link text-danger" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidebar">
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="cars.php">🏠 Cars</a>
    <a href="spare_parts.php">🛠️ Spare Parts</a>
     <a href="Customer.php">👥 Customer</a>
    <a href="sales.php">💰 Sales</a>
    <a href="users.php">👥 Manage Users</a>
    <a href="booking.php">📞Booking</a>
    <!-- New Services Link -->
    <a href="services.php">🛎️ Services</a>
    <a href="logout.php" class="text-danger">🚪 Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">
    <?php
        $page = $_GET['page'] ?? '';

        switch ($page) {
            case 'car_600':
                include 'pages/car_600.php';
                break;
            case 'car_800':
                include 'pages/car_800.php';
                break;
            case 'car_1000':
                include 'pages/car_1000.php';
                break;
            case 'car_1300':
                include 'pages/car_1300.php';
                break;
            case 'car_1500':
                include 'pages/car_1500.php';
                break;
            case 'car_2000':
                include 'pages/car_2000.php';
                break;
            case 'car_3500':
                include 'pages/car_3500.php';
                break;
            default:
                echo "<h3>Welcome to Showroom Dashboard</h3>";
        }
    ?>
</div>

<!-- Scripts -->
<script>
    function toggleCarMenu() {
        var menu = document.getElementById("car-menu");
        menu.style.display = menu.style.display === "none" ? "block" : "none";
    }

    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
        localStorage.setItem('theme', document.body.classList.contains('dark-mode') ? 'dark' : 'light');
    }

    function setLanguage(lang) {
        alert("Switching to " + (lang === "ur" ? "Urdu" : "English"));
        // In future, you can load translation files here
    }

    // Apply saved theme on load
    window.onload = () => {
        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
        }
    };
</script>

</body>
</html>
