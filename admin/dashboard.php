<?php
include 'db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            color: #f5f5f5;
            background: #203a43; /* Static background for performance */
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 56px;
            left: 0;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(8px);
            border-right: 1px solid rgba(255, 255, 255, 0.15);
            padding-top: 20px;
        }
        .sidebar a {
            color: #f1f1f1;
            padding: 12px 20px;
            display: block;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateX(4px);
            border-radius: 6px;
        }

        .navbar-brand { font-weight: 600; font-size: 18px; color: #fff !important; }

        .main-content {
            margin-left: 250px;
            margin-top: 56px;
            padding: 20px;
            font-size: 15px;
            color: #f5f5f5;
        }

        .card-glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border-radius: 14px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 14px rgba(0,0,0,0.2);
            transition: all 0.2s ease;
        }
        .card-glass:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.25); }
        .card-glass h4 { font-size: 16px; margin-bottom: 8px; color: #f8f9fa; }
        .card-glass p { font-size: 22px; font-weight: 700; color: #f8c146; margin: 0; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm" style="backdrop-filter: blur(8px); background: rgba(0, 0, 0, 0.6);">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">Showroom Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#dashboardNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="dashboardNavbar">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link text-light" href="#">Profile</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

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

<div class="main-content">
<?php
$current_page = basename($_SERVER['PHP_SELF']);
$action = $_GET['action'] ?? '';
$show_dashboard_charts = ($current_page === 'dashboard.php' && $action === '');

if ($show_dashboard_charts) {

    // Combine all counts in one query
    $counts = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT
        (SELECT COUNT(*) FROM cars) AS cars_count,
        (SELECT COUNT(*) FROM spare_parts) AS parts_count,
        (SELECT COUNT(*) FROM services) AS services_count,
        (SELECT COUNT(*) FROM customer) AS customers_count
    "));
    $cars_count = $counts['cars_count'];
    $parts_count = $counts['parts_count'];
    $services_count = $counts['services_count'];
    $customers_count = $counts['customers_count'];

    // Monthly revenue query combined
    $revenueSales = array_fill(0, 12, 0);
    $revenueServices = array_fill(0, 12, 0);

    $res = mysqli_query($conn, "
        SELECT MONTH(`date`) AS m, SUM(REPLACE(price, ',', '')) AS total, 'sales' AS type FROM sales GROUP BY MONTH(`date`)
        UNION ALL
        SELECT MONTH(`created_at`) AS m, SUM(price) AS total, 'services' AS type FROM services GROUP BY MONTH(`created_at`)
    ");
    while ($r = mysqli_fetch_assoc($res)) {
        $monthIndex = intval($r['m']) - 1;
        if ($r['type'] === 'sales') $revenueSales[$monthIndex] = floatval($r['total']);
        else $revenueServices[$monthIndex] = floatval($r['total']);
    }
?>

<h3 class="mb-4">Welcome to Showroom Dashboard</h3>

<div class="row g-4 mb-4">
    <div class="col-md-3"><div class="card-glass"><h4>Total Cars</h4><p><?= $cars_count ?></p></div></div>
    <div class="col-md-3"><div class="card-glass"><h4>Spare Parts</h4><p><?= $parts_count ?></p></div></div>
    <div class="col-md-3"><div class="card-glass"><h4>Services</h4><p><?= $services_count ?></p></div></div>
    <div class="col-md-3"><div class="card-glass"><h4>Customers</h4><p><?= $customers_count ?></p></div></div>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card-glass p-3">
            <h4>Monthly Revenue (Sales + Services)</h4>
            <canvas id="salesChart"></canvas>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card-glass p-3">
            <h4>Inventory & Services Ratio</h4>
            <canvas id="inventoryChart"></canvas>
        </div>
    </div>
</div>

<?php } ?>
</div>

<?php if ($show_dashboard_charts) { ?>
<script>
const salesRevenueData = <?= json_encode($revenueSales) ?>;
const servicesRevenueData = <?= json_encode($revenueServices) ?>;
const carsCount = <?= $cars_count ?>;
const partsCount = <?= $parts_count ?>;
const servicesCount = <?= $services_count ?>;

const salesChartEl = document.getElementById('salesChart');
const inventoryChartEl = document.getElementById('inventoryChart');

if(salesChartEl){
    new Chart(salesChartEl, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [
                { label: 'Sales Revenue', data: salesRevenueData, backgroundColor: 'rgba(54,162,235,0.85)', borderRadius: 6 },
                { label: 'Services Revenue', data: servicesRevenueData, backgroundColor: 'rgba(255,99,132,0.85)', borderRadius: 6 }
            ]
        },
        options: { responsive:true, plugins:{ legend:{labels:{color:'#fff'}} }, scales:{ x:{stacked:true,ticks:{color:'#fff'}}, y:{stacked:true,beginAtZero:true,ticks:{color:'#fff',callback:v=>'PKR '+Number(v).toLocaleString()}} } }
    });
}

if(inventoryChartEl){
    new Chart(inventoryChartEl, {
        type: 'pie',
        data: { labels:['Cars','Spare Parts','Services'], datasets:[{ data:[carsCount,partsCount,servicesCount], backgroundColor:['#36a2eb','#ffcd56','#9b59b6'] }] },
        options: { responsive:true, plugins:{ legend:{position:'bottom',labels:{color:'#fff'}} } }
    });
}
</script>
<?php } ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
