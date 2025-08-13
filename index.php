<?php
$cars = [
    ["name" => "BMW M4-Comp", "price" => "$55,000", "image" => "assets/images/car1.jpeg", "category" => "Sports"],
    ["name" => "Mercedes G-Wagon", "price" => "$60,000", "image" => "assets/images/car2.jpeg", "category" => "SUV"],
    ["name" => "Mercedes C-Class", "price" => "$45,000", "image" => "assets/images/car3.jpeg", "category" => "Sedan"],
    ["name" => "Porsche 911", "price" => "$120,000", "image" => "assets/images/car4.jpeg", "category" => "Sports"],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Showroom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .card img {
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .card:hover img {
            transform: scale(1.05);
        }
        .btn-custom {
            width: 48%;
        }
        /* Animation for car names */
        .animated-name {
            display: inline-block;
            animation: namePulse 2s infinite ease-in-out;
        }
        @keyframes namePulse {
            0%, 100% { transform: scale(1); color: #000; }
            50% { transform: scale(1.08); color: #f8c146; }
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<!-- Hero -->
<section class="hero text-center text-white" 
    style="position: relative; height: 300px; display: flex; flex-direction: column; justify-content: center; background: url('assets/images/hero.jpeg') center/cover;">
    <div style="position:absolute; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.4);"></div>
    <h1 style="position:relative; z-index:1;">Welcome to Our Showroom</h1>
    <p style="position:relative; z-index:1;">Find your dream car today</p>
    <a href="services.php" class="btn btn-warning text-dark" style="position:relative; z-index:1;">Explore Services</a>
</section>

<!-- Search & Filter -->
<div class="container my-4">
    <div class="row g-2">
        <div class="col-md-6">
            <input type="text" id="searchBox" class="form-control" placeholder="Search for a car...">
        </div>
        <div class="col-md-6 text-md-end">
            <button class="btn btn-outline-primary filter-btn" data-category="All">All</button>
            <button class="btn btn-outline-primary filter-btn" data-category="SUV">SUV</button>
            <button class="btn btn-outline-primary filter-btn" data-category="Sedan">Sedan</button>
            <button class="btn btn-outline-primary filter-btn" data-category="Sports">Sports</button>
        </div>
    </div>
</div>

<!-- Featured Cars -->
<div class="container my-5">
    <h2 class="mb-4">Featured Cars</h2>
    <div class="row" id="carList">
        <?php 
        $delay = 0; 
         include 'db.php';

      $sql = "SELECT * FROM cars ORDER BY id DESC";
      $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($car = $result->fetch_assoc()) {

        ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 car-item" 
             data-name="<?= $car['name'] ?>" 
             data-model="<?= strtolower($car['model']) ?>"
             data-aos="fade-up" 
             data-aos-duration="800" 
             data-aos-delay="<?= $delay ?>">
            <div class="card h-100 shadow-sm border-0">
              <img src="admin/uploads/<?= $car['image'] ?>" class="card-img-top" alt="<?= $car['name'] ?>">
                <div class="card-body text-center">
                    <h5 class="card-title animated-name"><?= $car['name'] ?></h5>
                    <p class="card-text text-muted"><?= $car['price'] ?></p>
                    <div class="d-flex justify-content-between">
                        <a href="book.php?car=<?= urlencode($car['name']) ?>" class="btn btn-warning btn-sm btn-custom">Book Now</a>
                        <a href="buy.php?car=<?= urlencode($car['name']) ?>" class="btn btn-success btn-sm btn-custom">Buy Now</a>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            $delay += 100; // Stagger animation for each card
        } }
        ?>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
    &copy; <?= date("Y") ?> Car Showroom. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ once: true });

    $("#searchBox").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".car-item").filter(function() {
            $(this).toggle($(this).data("name").indexOf(value) > -1);
        });
    });

    $(".filter-btn").on("click", function() {
        var category = $(this).data("category");
        if (category === "All") {
            $(".car-item").show();
        } else {
            $(".car-item").hide().filter(function() {
                return $(this).data("category") === category;
            }).show();
        }
    });
</script>
</body>
</html>
