<?php
include 'dashboard.php';
include 'db.php';
?>

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    AOS.init({ duration: 800, once: true });

    // Table search functionality
    const searchInput = document.getElementById("searchInput");
    if(searchInput){
        searchInput.addEventListener("keyup", function() {
            const filter = searchInput.value.toLowerCase();
            document.querySelectorAll("table tbody tr").forEach(tr => {
                tr.style.display = tr.textContent.toLowerCase().includes(filter) ? "" : "none";
            });
        });
    }
});
</script>

<div class="main-content">
    <h2 data-aos="fade-down">💰 Sales Reports</h2>

    <!-- Search Bar with Magnifier Icon -->
    <div class="mb-3" data-aos="fade-down">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control" id="searchInput" placeholder="Search Sales...">
        </div>
    </div>

    <?php
    $total_sales_value = rand(50000,1000000);
    echo "<div class='alert alert-info fw-bold' data-aos='flip-left'>
        Approx. Total Sales Value: <span class='text-dark'>".number_format($total_sales_value)." PKR</span>
    </div>";
    ?>

    <div class="card shadow border-0 table-responsive" data-aos="fade-up">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th><th>Date</th><th>Name</th><th>Type</th><th>Product</th><th>Price</th><th>Payment Type</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sales = $conn->query("SELECT * FROM sales ORDER BY id DESC");
                while($row = $sales->fetch_assoc()){
                    echo "<tr data-aos='fade-up'>
                        <td>{$row['id']}</td><td>{$row['date']}</td><td>{$row['name']}</td>
                        <td>{$row['types']}</td><td>{$row['product']}</td><td>{$row['price']}</td>
                        <td>{$row['pay_type']}</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
