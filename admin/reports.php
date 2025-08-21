<?php 
include 'dashboard.php'; 
include 'db.php';

$report = $_GET['report'] ?? 'all';
?>

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    AOS.init({ duration: 800, once: true });

    // Animate progress bars
    document.querySelectorAll(".progress-bar").forEach(function(bar) {
        let finalWidth = bar.getAttribute("data-width");
        if (!finalWidth) return;
        bar.style.width = "0%";
        setTimeout(() => { bar.style.width = finalWidth; }, 300);
    });

    // 🔍 Global Search across all visible tables
    document.getElementById("globalSearch").addEventListener("keyup", function() {
        let value = this.value.toLowerCase();
        document.querySelectorAll("table tbody tr").forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value) ? "" : "none";
        });
    });

    // 📅 Show/Hide Date Filters (only for All Reports)
    let dateFilters = document.getElementById("dateFilters");
    if ("<?= $report ?>" === "all") {
        dateFilters.style.display = "flex";
    } else {
        dateFilters.style.display = "none";
    }
});
</script>

<style>
.progress { border-radius: 50px; overflow: hidden; margin-bottom: 15px; }
.progress-bar { transition: width 1.5s ease-in-out; border-radius: 50px; font-weight: bold; color:#fff;}
.report-btn.active { opacity: 1; transform: scale(1.05); box-shadow: 0 0 12px rgba(0,0,0,0.25); background-color: #343a40 !important; color:#fff !important;}
.report-btn { opacity: 0.85; transition: all 0.3s ease-in-out; }
.table-hover tbody tr:hover { background-color: rgba(0,123,255,0.1); }
#globalSearch { max-width: 300px; }
#dateFilters { gap: 10px; display: none; }

/* 🔥 Professional Styling */
.filters-box {
    background: #ffffff;
    border: 1px solid #dee2e6;
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0px 2px 6px rgba(0,0,0,0.1);
}
.filters-box input,
.filters-box .btn {
    min-width: 120px;
}

/* 📊 Reports Heading Styling */
h2.page-heading {
    font-weight: 900;
    font-size: 46px;                 /* Bigger size */
    color: #ffffff;                  /* Pure white */
    text-shadow: 3px 3px 8px rgba(0,0,0,0.8); /* Strong readability on dark green */
    letter-spacing: 1.5px;
    margin-bottom: 25px;
}
</style>

<div class="main-content">
    
    <!-- Heading moved UP separately -->
    <div class="mb-4 text-center">
        <h2 class="page-heading" data-aos="fade-down">📊 REPORTS</h2>
    </div>

    <!-- Filters Row in a Professional Box -->
    <div class="filters-box mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <!-- 🔍 Global Search Bar -->
        <input type="text" id="globalSearch" class="form-control form-control-md" placeholder="🔍 Search Reports...">

        <!-- 📅 Date Filters (Visible only on 'All') -->
        <div id="dateFilters" class="d-flex align-items-center">
            <input type="date" id="startDate" class="form-control form-control-md">
            <input type="date" id="endDate" class="form-control form-control-md">
        </div>

        <!-- Report Buttons -->
        <div class="btn-group">
            <a href="?report=all" class="btn btn-dark btn-sm report-btn <?= $report=='all' ? 'active' : '' ?>">All</a>
            <a href="?report=services" class="btn btn-primary btn-sm report-btn <?= $report=='services' ? 'active' : '' ?>">Services</a>
            <a href="?report=spareparts" class="btn btn-success btn-sm report-btn <?= $report=='spareparts' ? 'active' : '' ?>">Spare Parts</a>
            <a href="?report=cars" class="btn btn-warning btn-sm report-btn <?= $report=='cars' ? 'active' : '' ?>">Cars</a>
            <a href="?report=sales" class="btn btn-info btn-sm report-btn <?= $report=='sales' ? 'active' : '' ?>">Sales</a>
            <a href="?report=booking" class="btn btn-secondary btn-sm report-btn <?= $report=='booking' ? 'active' : '' ?>">Booking</a>
            <a href="?report=customer" class="btn btn-danger btn-sm report-btn <?= $report=='customer' ? 'active' : '' ?>">Customer</a>
        </div>
    </div>

    <div class="accordion" id="reportsAccordion">

    <?php
    function createProgress($value, $max=1000000, $color='primary') {
        $percent = min(round(($value/$max)*100), 100) . '%';
        echo "<div class='alert alert-$color fw-bold' data-aos='flip-left'>Approx. Total Value: <span class='text-dark'>".number_format($value)." PKR</span></div>";
        echo "<div class='progress' data-aos='zoom-in'><div class='progress-bar bg-$color' role='progressbar' data-width='$percent'>$percent</div></div>";
    }

    // ================= SECTIONS BELOW (unchanged) =================
    // Services
    if($report=='all' || $report=='services'):
    $total_services_value = rand(10000,50000); ?>
    <div class="accordion-item mb-3" data-aos="fade-up">
    <h2 class="accordion-header"><button class="accordion-button" type="button">🛎️ Services Reports</button></h2>
    <div class="accordion-body">
    <?php createProgress($total_services_value,50000,'primary'); ?>
    <div class="card shadow border-0 table-responsive"><table class="table table-hover align-middle">
    <thead class="table-dark"><tr><th>ID</th><th>Name</th><th>Category</th><th>Description</th><th>Price</th><th>Image</th><th>Created At</th></tr></thead>
    <tbody>
    <?php $services = $conn->query("SELECT * FROM services ORDER BY id DESC");
    while($row = $services->fetch_assoc()){
    echo "<tr data-aos='fade-up'>
    <td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['category']}</td>
    <td>{$row['description']}</td><td>{$row['price']}</td>
    <td><img src='uploads/{$row['image']}' class='img-thumbnail' style='height:50px;'></td>
    <td>{$row['created_at']}</td></tr>";
    } ?>
    </tbody></table></div></div></div>
    <?php endif; ?>

    <!-- Spare Parts -->
    <?php if($report=='all' || $report=='spareparts'):
    $total_parts_value = 0;
    $parts_total_query = $conn->query("SELECT price, stock FROM spare_parts");
    while($row_total = $parts_total_query->fetch_assoc()){
    $price = (float) str_replace(',', '', $row_total['price']);
    $stock = (int) $row_total['stock'];
    $total_parts_value += $price*$stock;
    } ?>
    <div class="accordion-item mb-3" data-aos="fade-up">
    <h2 class="accordion-header"><button class="accordion-button" type="button">🛠️ Spare Parts Inventory</button></h2>
    <div class="accordion-body">
    <?php createProgress($total_parts_value,500000,'success'); ?>
    <div class="card shadow border-0 table-responsive"><table class="table table-hover align-middle">
    <thead class="table-dark"><tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Image</th></tr></thead>
    <tbody>
    <?php $parts = $conn->query("SELECT * FROM spare_parts ORDER BY id DESC");
    while($row = $parts->fetch_assoc()){
    echo "<tr data-aos='fade-up'>
    <td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['category']}</td>
    <td>{$row['price']}</td><td>{$row['stock']}</td>
    <td><img src='uploads/{$row['image']}' class='img-thumbnail' style='height:50px;'></td></tr>";
    } ?>
    </tbody></table></div></div></div>
    <?php endif; ?>

    <!-- Cars -->
    <?php if($report=='all' || $report=='cars'):
    $total_cars_value = rand(500000,5000000); ?>
    <div class="accordion-item mb-3" data-aos="fade-up">
    <h2 class="accordion-header"><button class="accordion-button" type="button">🚗 Cars Reports</button></h2>
    <div class="accordion-body">
    <?php createProgress($total_cars_value,5000000,'warning'); ?>
    <div class="card shadow border-0 table-responsive"><table class="table table-hover align-middle">
    <thead class="table-dark"><tr><th>ID</th><th>Name</th><th>Model</th><th>Engine CC</th><th>Price</th><th>Image</th><th>Added On</th></tr></thead>
    <tbody>
    <?php $cars = $conn->query("SELECT * FROM cars ORDER BY id DESC");
    while($row = $cars->fetch_assoc()){
    echo "<tr data-aos='fade-up'>
    <td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['model']}</td>
    <td>{$row['engine_cc']}</td><td>{$row['price']}</td>
    <td><img src='uploads/{$row['image']}' class='img-thumbnail' style='height:50px;'></td>
    <td>{$row['added_on']}</td></tr>";
    } ?>
    </tbody></table></div></div></div>
    <?php endif; ?>

    <!-- Sales -->
    <?php if($report=='all' || $report=='sales'):
    $total_sales_value = rand(50000,1000000); ?>
    <div class="accordion-item mb-3" data-aos="fade-up">
    <h2 class="accordion-header"><button class="accordion-button" type="button">💰 Sales Reports</button></h2>
    <div class="accordion-body">
    <?php createProgress($total_sales_value,1000000,'info'); ?>
    <div class="card shadow border-0 table-responsive"><table class="table table-hover align-middle">
    <thead class="table-dark"><tr><th>ID</th><th>Date</th><th>Name</th><th>Type</th><th>Product</th><th>Price</th><th>Payment Type</th></tr></thead>
    <tbody>
    <?php $sales = $conn->query("SELECT * FROM sales ORDER BY id DESC");
    while($row = $sales->fetch_assoc()){
    echo "<tr data-aos='fade-up'>
    <td>{$row['id']}</td><td>{$row['date']}</td><td>{$row['name']}</td>
    <td>{$row['types']}</td><td>{$row['product']}</td><td>{$row['price']}</td>
    <td>{$row['pay_type']}</td></tr>";
    } ?>
    </tbody></table></div></div></div>
    <?php endif; ?>

    <!-- Booking -->
    <?php if($report=='all' || $report=='booking'):
    $total_booking_value = rand(10000,200000); ?>
    <div class="accordion-item mb-3" data-aos="fade-up">
    <h2 class="accordion-header"><button class="accordion-button" type="button">📞 Booking Reports</button></h2>
    <div class="accordion-body">
    <?php createProgress($total_booking_value,200000,'secondary'); ?>
    <div class="card shadow border-0 table-responsive"><table class="table table-hover align-middle">
    <thead class="table-dark"><tr><th>ID</th><th>Name</th><th>Contact</th><th>Booking Type</th><th>Preferred Time</th><th>Advance Pay</th><th>Pay Mode</th></tr></thead>
    <tbody>
    <?php $booking = $conn->query("SELECT * FROM booking ORDER BY id DESC");
    while($row = $booking->fetch_assoc()){
    echo "<tr data-aos='fade-up'>
    <td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['contact']}</td>
    <td>{$row['booking_type']}</td><td>{$row['pref_time']}</td><td>{$row['adv_pay']}</td>
    <td>{$row['pay_mode']}</td></tr>";
    } ?>
    </tbody></table></div></div></div>
    <?php endif; ?>

    <!-- Customer -->
    <?php if($report=='all' || $report=='customer'):
    $total_customer_value = rand(50000,500000); ?>
    <div class="accordion-item mb-3" data-aos="fade-up">
    <h2 class="accordion-header"><button class="accordion-button" type="button">👥 Customer Reports</button></h2>
    <div class="accordion-body">
    <?php createProgress($total_customer_value,500000,'danger'); ?>
    <div class="card shadow border-0 table-responsive"><table class="table table-hover align-middle">
    <thead class="table-dark"><tr><th>ID</th><th>Name</th><th>Email</th><th>Contact</th><th>Address</th></tr></thead>
    <tbody>
    <?php $customers = $conn->query("SELECT * FROM customer ORDER BY id DESC");
    while($row = $customers->fetch_assoc()){
    echo "<tr data-aos='fade-up'>
    <td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['email']}</td>
    <td>{$row['contact']}</td><td>{$row['address']}</td></tr>";
    } ?>
    </tbody></table></div></div></div>
    <?php endif; ?>

    </div><!-- /accordion -->
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
