<?php
include 'db.php'; 
include 'dashboard.php'; // keeps sidebar + header

// Fetch Data
$sales = $conn->query("SELECT * FROM sales");
$customers = $conn->query("SELECT * FROM customer");
$spareParts = $conn->query("SELECT * FROM spare_parts");
$cars = $conn->query("SELECT * FROM cars");
$services = $conn->query("SELECT * FROM services");

// For charts - collect data
$salesData = [];
$salesAmount = [];
while($row = $conn->query("SELECT date, amount FROM sales")) {
    while($r = $row->fetch_assoc()) {
        $salesData[] = $r['date'];
        $salesAmount[] = $r['amount'];
    }
}

$carNames = [];
$carStock = [];
$carsQuery = $conn->query("SELECT name, price FROM cars");
while($c = $carsQuery->fetch_assoc()){
    $carNames[] = $c['name'];
    $carStock[] = $c['price'];
}

$partNames = [];
$partStock = [];
$partsQuery = $conn->query("SELECT name, stock FROM spare_parts");
while($p = $partsQuery->fetch_assoc()){
    $partNames[] = $p['name'];
    $partStock[] = $p['stock'];
}
?>

<div class="main-content p-4">
    <h2 class="mb-4">📊 Reports Dashboard</h2>

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="reportTabs" role="tablist">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#sales">💰 Sales</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#customers">👥 Customers</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#inventory">🚗 Inventory</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#services">🛎️ Services</a></li>
    </ul>

    <div class="tab-content mt-3">
        <!-- Sales Report -->
        <div class="tab-pane fade show active" id="sales">
            <h4>💰 Sales Report</h4>
            <table class="table table-bordered table-striped">
                <tr><th>ID</th><th>Customer</th><th>Item</th><th>Amount</th><th>Date</th></tr>
                <?php 
                $sales->data_seek(0);
                while($row = $sales->fetch_assoc()){ ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['customer_name'] ?></td>
                        <td><?= $row['item_name'] ?></td>
                        <td><?= $row['amount'] ?></td>
                        <td><?= $row['date'] ?></td>
                    </tr>
                <?php } ?>
            </table>
            <canvas id="salesChart" height="100"></canvas>
        </div>

        <!-- Customers Report -->
        <div class="tab-pane fade" id="customers">
            <h4>👥 Customer Report</h4>
            <table class="table table-bordered table-striped">
                <tr><th>ID</th><th>Name</th><th>Phone</th><th>Email</th></tr>
                <?php 
                $customers->data_seek(0);
                while($row = $customers->fetch_assoc()){ ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['phone'] ?></td>
                        <td><?= $row['email'] ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <!-- Inventory Report -->
        <div class="tab-pane fade" id="inventory">
            <h4>🚗 Inventory Report</h4>
            <h6>Cars</h6>
            <table class="table table-bordered table-striped">
                <tr><th>ID</th><th>Name</th><th>Model</th><th>Engine</th><th>Price</th></tr>
                <?php 
                $cars->data_seek(0);
                while($row = $cars->fetch_assoc()){ ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['model'] ?></td>
                        <td><?= $row['engine_cc'] ?></td>
                        <td><?= $row['price'] ?></td>
                    </tr>
                <?php } ?>
            </table>

            <h6>Spare Parts</h6>
            <table class="table table-bordered table-striped">
                <tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th></tr>
                <?php 
                $spareParts->data_seek(0);
                while($row = $spareParts->fetch_assoc()){ ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['category'] ?></td>
                        <td><?= $row['price'] ?></td>
                        <td><?= $row['stock'] ?></td>
                    </tr>
                <?php } ?>
            </table>

            <canvas id="inventoryChart" height="100"></canvas>
        </div>

        <!-- Services Report -->
        <div class="tab-pane fade" id="services">
            <h4>🛎️ Services Report</h4>
            <table class="table table-bordered table-striped">
                <tr><th>ID</th><th>Service</th><th>Price</th><th>Added On</th></tr>
                <?php 
                $services->data_seek(0);
                while($row = $services->fetch_assoc()){ ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['service_name'] ?></td>
                        <td><?= $row['price'] ?></td>
                        <td><?= $row['added_on'] ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Sales Chart
new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
        labels: <?= json_encode($salesData) ?>,
        datasets: [{
            label: 'Sales Amount',
            data: <?= json_encode($salesAmount) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            fill: true,
            tension: 0.3
        }]
    }
});

// Inventory Chart
new Chart(document.getElementById('inventoryChart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($partNames) ?>,
        datasets: [{
            label: 'Spare Parts Stock',
            data: <?= json_encode($partStock) ?>,
            backgroundColor: 'rgba(255, 99, 132, 0.5)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    }
});
</script>
