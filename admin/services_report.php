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
    <h2 data-aos="fade-down">🛎️ Services Reports</h2>

    <!-- Search Bar with Magnifier Icon -->
    <div class="mb-3" data-aos="fade-down">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control" id="searchInput" placeholder="Search Services...">
        </div>
    </div>

    <?php
    $total_services_value = rand(10000,50000);
    echo "<div class='alert alert-primary fw-bold' data-aos='flip-left'>
        Approx. Total Value: <span class='text-dark'>".number_format($total_services_value)." PKR</span>
    </div>";
    ?>

    <div class="card shadow border-0 table-responsive" data-aos="fade-up">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th><th>Name</th><th>Category</th><th>Description</th><th>Price</th><th>Image</th><th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $services = $conn->query("SELECT * FROM services ORDER BY id DESC");
                while($row = $services->fetch_assoc()) {
                    echo "<tr data-aos='fade-up'>
                        <td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['category']}</td>
                        <td>{$row['description']}</td><td>{$row['price']}</td>
                        <td><img src='uploads/{$row['image']}' class='img-thumbnail' style='height:50px;'></td>
                        <td>{$row['created_at']}</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
