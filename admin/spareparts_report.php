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
    <h2 data-aos="fade-down">🛠️ Spare Parts Inventory</h2>

    <!-- Search Bar with Magnifier Icon -->
    <div class="mb-3" data-aos="fade-down">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control" id="searchInput" placeholder="Search Spare Parts...">
        </div>
    </div>

    <?php
    $total_parts_value = 0;
    $parts_total_query = $conn->query("SELECT price, stock FROM spare_parts");
    while($row_total = $parts_total_query->fetch_assoc()){
        $price = (float) str_replace(',', '', $row_total['price']);
        $stock = (int) $row_total['stock'];
        $total_parts_value += $price*$stock;
    }
    echo "<div class='alert alert-success fw-bold' data-aos='flip-left'>
        Approx. Total Inventory Value: <span class='text-dark'>".number_format($total_parts_value)." PKR</span>
    </div>";
    ?>

    <div class="card shadow border-0 table-responsive" data-aos="fade-up">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Image</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $parts = $conn->query("SELECT * FROM spare_parts ORDER BY id DESC");
                while($row = $parts->fetch_assoc()){
                    echo "<tr data-aos='fade-up'>
                        <td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['category']}</td>
                        <td>{$row['price']}</td><td>{$row['stock']}</td>
                        <td><img src='uploads/{$row['image']}' class='img-thumbnail' style='height:50px;'></td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
