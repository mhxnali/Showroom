<?php  
include 'dashboard.php'; 
include 'db.php';
include 'car_financials.php'; // Include the car financial data

$report = $_GET['report'] ?? 'all';
$page   = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit  = 5;
$offset = ($page - 1) * $limit;

// Date filters
$start_date = $_GET['start_date'] ?? '';
$end_date   = $_GET['end_date'] ?? '';
$dateFilter = "";

// Apply date filter if values are provided
if (!empty($start_date) && !empty($end_date)) {
    $dateFilter = " WHERE created_at BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59' ";
} elseif (!empty($start_date)) {
    $dateFilter = " WHERE created_at >= '$start_date 00:00:00' ";
} elseif (!empty($end_date)) {
    $dateFilter = " WHERE created_at <= '$end_date 23:59:59' ";
}

// Switch tables based on report type
switch ($report) {
    case 'cars':
        $query = "SELECT * FROM cars $dateFilter ORDER BY id DESC LIMIT $limit OFFSET $offset";
        $countQuery = "SELECT COUNT(*) as total FROM cars $dateFilter";
        $columns = ['ID','Name','Model','Engine CC','Price','Image','Added On'];
        break;
    case 'cars_profitloss':
        // Fetch cars data with date filter
        $query = "SELECT * FROM cars $dateFilter ORDER BY id DESC LIMIT $limit OFFSET $offset";
        $countQuery = "SELECT COUNT(*) as total FROM cars $dateFilter";
        $columns = ['ID','Name','Model','Engine CC','Selling Price','Actual Cost','Commission','Profit/Loss','Image','Added On'];
        break;
    case 'sales':
        $query = "SELECT * FROM sales $dateFilter ORDER BY id DESC LIMIT $limit OFFSET $offset";
        $countQuery = "SELECT COUNT(*) as total FROM sales $dateFilter";
        $columns = ['ID','Date','Name','Types','Product','Price','Pay Type'];
        break;
    case 'customers':
        $query = "SELECT * FROM customer $dateFilter ORDER BY id DESC LIMIT $limit OFFSET $offset";
        $countQuery = "SELECT COUNT(*) as total FROM customer $dateFilter";
        $columns = ['ID','Name','Email','Contact','Address'];
        break;
    case 'booking':
        $query = "SELECT * FROM booking $dateFilter ORDER BY id DESC LIMIT $limit OFFSET $offset";
        $countQuery = "SELECT COUNT(*) as total FROM booking $dateFilter";
        $columns = ['ID','Name','Contact','Booking Type','Preferred Time','Advance Pay','Pay Mode'];
        break;
    case 'services':
        $query = "SELECT * FROM services $dateFilter ORDER BY id DESC LIMIT $limit OFFSET $offset";
        $countQuery = "SELECT COUNT(*) as total FROM services $dateFilter";
        $columns = ['ID','Name','Category','Description','Price','Image','Created At'];
        break;
    case 'spareparts':
        $query = "SELECT * FROM spare_parts $dateFilter ORDER BY id DESC LIMIT $limit OFFSET $offset";
        $countQuery = "SELECT COUNT(*) as total FROM spare_parts $dateFilter";
        $columns = ['ID','Name','Category','Price','Stock','Image'];
        break;
    case 'profitloss':
        // Calculate profit and loss using actual financial data
        $columns = ['Category', 'Revenue', 'Cost', 'Commission', 'Profit/Loss'];
        
        // Fetch data from relevant tables
        $carsQuery = "SELECT id, price FROM cars $dateFilter";
        $servicesQuery = "SELECT price FROM services $dateFilter";
        $sparepartsQuery = "SELECT price FROM spare_parts $dateFilter";
        
        $carsResult = mysqli_query($conn, $carsQuery);
        $servicesResult = mysqli_query($conn, $servicesQuery);
        $sparepartsResult = mysqli_query($conn, $sparepartsQuery);
        
        // Initialize variables
        $carsRevenue = 0;
        $carsCost = 0;
        $carsCommission = 0;
        
        $servicesRevenue = 0;
        $servicesCost = 0;
        $servicesCommission = 0;
        
        $sparepartsRevenue = 0;
        $sparepartsCost = 0;
        $sparepartsCommission = 0;
        
        // Calculate actual revenue, cost, and commission for cars
        while ($row = mysqli_fetch_assoc($carsResult)) {
            $carId = $row['id'];
            $price = floatval($row['price']);
            
            // Get cost and commission from configuration
            if (isset($carFinancials[$carId])) {
                $costPrice = $carFinancials[$carId]['cost'];
                $commission = $carFinancials[$carId]['commission'];
            } else {
                // Fallback if not in configuration
                $costPrice = $price * 0.70;
                $commission = $price * 0.05;
            }
            
            $carsRevenue += $price;
            $carsCost += $costPrice;
            $carsCommission += $commission;
        }
        
        // Calculate actual revenue, cost, and commission for services
        while ($row = mysqli_fetch_assoc($servicesResult)) {
            $price = isset($row['price']) ? floatval($row['price']) : 0;
            $costPrice = $price * 0.40; // 40% of revenue is cost
            $commission = $price * 0.10; // 10% commission
            
            $servicesRevenue += $price;
            $servicesCost += $costPrice;
            $servicesCommission += $commission;
        }
        
        // Calculate actual revenue, cost, and commission for spare parts
        while ($row = mysqli_fetch_assoc($sparepartsResult)) {
            $price = isset($row['price']) ? floatval($row['price']) : 0;
            $costPrice = $price * 0.60; // 60% of revenue is cost
            $commission = $price * 0.03; // 3% commission
            
            $sparepartsRevenue += $price;
            $sparepartsCost += $costPrice;
            $sparepartsCommission += $commission;
        }
        
        // Calculate profit/loss for each category
        $carsProfitLoss = $carsRevenue - $carsCost - $carsCommission;
        $servicesProfitLoss = $servicesRevenue - $servicesCost - $servicesCommission;
        $sparepartsProfitLoss = $sparepartsRevenue - $sparepartsCost - $sparepartsCommission;
        
        // Calculate totals
        $totalRevenue = $carsRevenue + $servicesRevenue + $sparepartsRevenue;
        $totalCost = $carsCost + $servicesCost + $sparepartsCost;
        $totalCommission = $carsCommission + $servicesCommission + $sparepartsCommission;
        $totalProfitLoss = $totalRevenue - $totalCost - $totalCommission;
        
        // Prepare report data
        $profitLossData = [
            [
                'Category' => 'Cars',
                'Revenue' => $carsRevenue,
                'Cost' => $carsCost,
                'Commission' => $carsCommission,
                'Profit/Loss' => $carsProfitLoss
            ],
            [
                'Category' => 'Services',
                'Revenue' => $servicesRevenue,
                'Cost' => $servicesCost,
                'Commission' => $servicesCommission,
                'Profit/Loss' => $servicesProfitLoss
            ],
            [
                'Category' => 'Spare Parts',
                'Revenue' => $sparepartsRevenue,
                'Cost' => $sparepartsCost,
                'Commission' => $sparepartsCommission,
                'Profit/Loss' => $sparepartsProfitLoss
            ],
            [
                'Category' => 'TOTAL',
                'Revenue' => $totalRevenue,
                'Cost' => $totalCost,
                'Commission' => $totalCommission,
                'Profit/Loss' => $totalProfitLoss
            ]
        ];
        
        // Set total pages to 1 since we're not paginating this report
        $totalPages = 1;
        break;
    default:
        $query = "SELECT * FROM services $dateFilter ORDER BY id DESC LIMIT $limit OFFSET $offset";
        $countQuery = "SELECT COUNT(*) as total FROM services $dateFilter";
        $columns = ['ID','Name','Category','Description','Price','Image','Created At'];
        break;
}

// Execute queries for non-profitloss reports
if ($report !== 'profitloss' && $report !== 'cars_profitloss') {
    $result = mysqli_query($conn, $query);
    $countResult = mysqli_query($conn, $countQuery);
    $totalRows = mysqli_fetch_assoc($countResult)['total'];
    $totalPages = ceil($totalRows / $limit);
} elseif ($report === 'cars_profitloss') {
    $result = mysqli_query($conn, $query);
    $countResult = mysqli_query($conn, $countQuery);
    $totalRows = mysqli_fetch_assoc($countResult)['total'];
    $totalPages = ceil($totalRows / $limit);
}
?>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<div class="main-content">
    <h1 class="text-center mb-4">Welcome to Showroom Dashboard</h1>
    <h2 class="text-center mb-4">Reports</h2>
    <!-- Report Buttons -->
    <div class="d-flex justify-content-center gap-2 mb-4 flex-wrap">
        <a href="reports.php?report=cars" class="btn btn-primary">Cars</a>
        <a href="reports.php?report=cars_profitloss" class="btn btn-info">Cars Profit & Loss</a>
        <a href="reports.php?report=sales" class="btn btn-primary">Sales</a>
        <a href="reports.php?report=customers" class="btn btn-primary">Customers</a>
        <a href="reports.php?report=booking" class="btn btn-primary">Booking</a>
        <a href="reports.php?report=services" class="btn btn-primary">Services</a>
        <a href="reports.php?report=spareparts" class="btn btn-primary">Spare Parts</a>
        <a href="reports.php?report=profitloss" class="btn btn-success">Profit & Loss</a>
    </div>
    <!-- Date Filter -->
    <form method="GET" class="d-flex justify-content-center gap-2 mb-4">
        <input type="hidden" name="report" value="<?= htmlspecialchars($report) ?>">
        <input type="date" name="start_date" value="<?= htmlspecialchars($start_date) ?>" class="form-control" style="max-width:200px;">
        <input type="date" name="end_date" value="<?= htmlspecialchars($end_date) ?>" class="form-control" style="max-width:200px;">
        <button type="submit" class="btn btn-success">Filter</button>
    </form>
    <!-- Table -->
    <div class="table-responsive" data-aos="fade-up">
        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <?php foreach ($columns as $col): ?>
                        <th><?= $col ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php if ($report === 'profitloss'): ?>
                    <?php foreach ($profitLossData as $row): ?>
                        <tr <?= $row['Category'] === 'TOTAL' ? 'class="table-primary font-weight-bold"' : '' ?>>
                            <?php foreach ($row as $key => $val): ?>
                                <td>
                                    <?php if ($key === 'Revenue' || $key === 'Cost' || $key === 'Commission' || $key === 'Profit/Loss'): ?>
                                        $<?= number_format($val, 2) ?>
                                        <?php if ($key === 'Profit/Loss'): ?>
                                            <span class="badge <?= $val >= 0 ? 'bg-success' : 'bg-danger' ?>">
                                                <?= $val >= 0 ? 'Profit' : 'Loss' ?>
                                            </span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?= htmlspecialchars($val) ?>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php elseif ($report === 'cars_profitloss' && isset($result) && mysqli_num_rows($result) > 0): ?>
                    <?php 
                    while ($row = mysqli_fetch_assoc($result)): 
                        // Get car details
                        $carId = $row['id'];
                        $sellingPrice = floatval($row['price']); // This is the actual selling price from your database
                        
                        // Get actual cost and commission from configuration
                        if (isset($carFinancials[$carId])) {
                            $actualCost = $carFinancials[$carId]['cost'];
                            $commission = $carFinancials[$carId]['commission'];
                        } else {
                            // Fallback if not in configuration
                            $actualCost = $sellingPrice * 0.70;
                            $commission = $sellingPrice * 0.05;
                        }
                        
                        // Calculate profit/loss
                        $profitLoss = $sellingPrice - $actualCost - $commission;
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['model']) ?></td>
                            <td><?= htmlspecialchars($row['engine_cc']) ?></td>
                            <td>$<?= number_format($sellingPrice, 2) ?></td>
                            <td>$<?= number_format($actualCost, 2) ?></td>
                            <td>$<?= number_format($commission, 2) ?></td>
                            <td class="<?= $profitLoss >= 0 ? 'text-success' : 'text-danger' ?>">
                                $<?= number_format($profitLoss, 2) ?>
                                <?php if ($profitLoss < 0): ?>
                                    <span class="badge bg-danger">Loss</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Profit</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($row['image'])): ?>
                                    <img src="uploads/<?= htmlspecialchars($row['image']) ?>" 
                                         alt="Image" 
                                         style="width:80px; height:80px; object-fit:cover; border-radius:8px;">
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['added_on'] ?? '') ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php elseif (isset($result) && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <?php foreach ($row as $key => $val): ?>
                                <td>
                                    <?php if (strtolower($key) === 'image' && !empty($val)): ?>
                                        <img src="uploads/<?= htmlspecialchars($val) ?>" 
                                             alt="Image" 
                                             style="width:80px; height:80px; object-fit:cover; border-radius:8px;">
                                    <?php else: ?>
                                        <?= htmlspecialchars($val) ?>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="<?= count($columns) ?>">No records found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- Pagination (only for non-profitloss reports) -->
    <?php if ($report !== 'profitloss' && isset($totalPages)): ?>
        <div class="d-flex justify-content-center mt-3">
            <nav>
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="reports.php?report=<?= $report ?>&page=<?= $i ?>&start_date=<?= $start_date ?>&end_date=<?= $end_date ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    <?php endif; ?>
</div>
<script>
  AOS.init();
</script>