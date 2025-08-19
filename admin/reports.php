        $salesData[] = $r['date'];
<?php 
include 'dashboard.php'; 
include 'db.php';
?>

<!-- AOS Library for Animations -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    AOS.init({ duration: 800, once: true });

    // Animate progress bars
    document.querySelectorAll(".progress-bar").forEach(function(bar) {
      let finalWidth = bar.getAttribute("data-width");
      bar.style.width = "0%";
      setTimeout(() => {
        bar.style.width = finalWidth;
      }, 300);
    });
  });
</script>

<style>
  /* Rounded progress bars */
  .progress {
    border-radius: 50px;
    overflow: hidden;
  }
  .progress-bar {
    transition: width 1.5s ease-in-out;
    border-radius: 50px;
  }
</style>

<div class="main-content">
    <h2 class="mb-4" data-aos="fade-down">📊 Reports Dashboard</h2>

    <!-- Services Reports -->
    <section class="mb-5" data-aos="fade-up">
        <div class="card shadow border-0">
            <div class="card-header bg-dark text-white">
                <h3 class="mb-0">🛎️ Services Reports</h3>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $services = $conn->query("SELECT * FROM services ORDER BY id DESC");
                        while($row = $services->fetch_assoc()) {
                            echo "<tr data-aos='fade-up'>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['category']}</td>
                                <td>{$row['description']}</td>
                                <td>{$row['price']}</td>
                                <td><img src='uploads/{$row['image']}' class='img-thumbnail' style='height:50px;'></td>
                                <td>{$row['created_at']}</td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Spare Parts Reports -->
    <section class="mb-5" data-aos="fade-up">
        <?php
        $total_parts_value = 0;
        $parts_total_query = $conn->query("SELECT price, stock FROM spare_parts");
        while($row_total = $parts_total_query->fetch_assoc()) {
            $price = (float) str_replace(',', '', $row_total['price']);
            $stock = (int) $row_total['stock'];
            $total_parts_value += $price * $stock;
        }
        ?>
        <div class="card shadow border-0">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">🛠️ Spare Parts Inventory</h3>
            </div>
            <div class="card-body">
                <div class="alert alert-primary fw-bold" data-aos="flip-left">
                    💰 Approx. Total Inventory Value: 
                    <span class="text-dark"><?= number_format($total_parts_value) ?> PKR</span>
                </div>
                <!-- Progress Bar -->
                <div class="progress mb-3" style="height:20px;" data-aos="zoom-in">
                  <div class="progress-bar bg-primary fw-bold" role="progressbar" data-width="70%">70%</div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Image</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $parts = $conn->query("SELECT * FROM spare_parts ORDER BY id DESC");
                            while($row = $parts->fetch_assoc()) {
                                echo "<tr data-aos='fade-up'>
                                    <td>{$row['id']}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['category']}</td>
                                    <td>{$row['price']}</td>
                                    <td>{$row['stock']}</td>
                                    <td><img src='uploads/{$row['image']}' class='img-thumbnail' style='height:50px;'></td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Cars Reports -->
    <section class="mb-5" data-aos="fade-up">
        <?php
        $total_cars_value = 0;
        $cars_total_query = $conn->query("SELECT price FROM cars");
        while($row_total = $cars_total_query->fetch_assoc()) {
            $price = (float) str_replace(',', '', preg_replace('/[^0-9.]/', '', $row_total['price']));
            $total_cars_value += $price;
        }
        ?>
        <div class="card shadow border-0">
            <div class="card-header bg-success text-white">
                <h3 class="mb-0">🚗 Cars Reports</h3>
            </div>
            <div class="card-body">
                <div class="alert alert-success fw-bold" data-aos="flip-left">
                    🚘 Approx. Total Cars Value: 
                    <span class="text-dark"><?= number_format($total_cars_value) ?> PKR</span>
                </div>
                <!-- Progress Bar -->
                <div class="progress mb-3" style="height:20px;" data-aos="zoom-in">
                  <div class="progress-bar bg-success fw-bold" role="progressbar" data-width="55%">55%</div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Model</th>
                                <th>Engine CC</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Added On</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cars = $conn->query("SELECT * FROM cars ORDER BY id DESC");
                            while($row = $cars->fetch_assoc()) {
                                echo "<tr data-aos='fade-up'>
                                    <td>{$row['id']}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['model']}</td>
                                    <td>{$row['engine_cc']}</td>
                                    <td>{$row['price']}</td>
                                    <td><img src='uploads/{$row['image']}' class='img-thumbnail' style='height:50px;'></td>
                                    <td>{$row['added_on']}</td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Sales Reports -->
    <section class="mb-5" data-aos="fade-up">
        <?php
        $total_sales = 0;
        $sales_total_query = $conn->query("SELECT price FROM sales");
        while($row_total = $sales_total_query->fetch_assoc()) {
            $price = (float) str_replace(',', '', preg_replace('/[^0-9.]/', '', $row_total['price']));
            $total_sales += $price;
        }
        ?>
        <div class="card shadow border-0">
            <div class="card-header bg-warning text-dark">
                <h3 class="mb-0">💰 Sales Reports</h3>
            </div>
            <div class="card-body">
                <div class="alert alert-warning fw-bold" data-aos="flip-left">
                    📈 Approx. Total Sales: 
                    <span class="text-dark"><?= number_format($total_sales) ?> PKR</span>
                </div>
                <!-- Progress Bar -->
                <div class="progress mb-3" style="height:20px;" data-aos="zoom-in">
                  <div class="progress-bar bg-warning text-dark fw-bold" role="progressbar" data-width="80%">80%</div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Payment Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sales = $conn->query("SELECT * FROM sales ORDER BY id DESC");
                            while($row = $sales->fetch_assoc()) {
                                echo "<tr data-aos='fade-up'>
                                    <td>{$row['id']}</td>
                                    <td>{$row['date']}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['types']}</td>
                                    <td>{$row['product']}</td>
                                    <td>{$row['price']}</td>
                                    <td>{$row['pay_type']}</td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Reports -->
    <section class="mb-5" data-aos="fade-up">
        <div class="card shadow border-0">
            <div class="card-header bg-info text-white">
                <h3 class="mb-0">📞 Booking Reports</h3>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Booking Type</th>
                            <th>Preferred Time</th>
                            <th>Advance Pay</th>
                            <th>Pay Mode</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $booking = $conn->query("SELECT * FROM booking ORDER BY id DESC");
                        while($row = $booking->fetch_assoc()) {
                            echo "<tr data-aos='fade-up'>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['contact']}</td>
                                <td>{$row['booking_type']}</td>
                                <td>{$row['pref_time']}</td>
                                <td>{$row['adv_pay']}</td>
                                <td>{$row['pay_mode']}</td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Customers Reports -->
    <section class="mb-5" data-aos="fade-up">
        <div class="card shadow border-0">
            <div class="card-header bg-secondary text-white">
                <h3 class="mb-0">👥 Customers Reports</h3>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $customers = $conn->query("SELECT * FROM customer ORDER BY id DESC");
                        while($row = $customers->fetch_assoc()) {
                            echo "<tr data-aos='fade-up'>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['contact']}</td>
                                <td>{$row['address']}</td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
