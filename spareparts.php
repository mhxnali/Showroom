<?php
include 'db.php';
?>

<?php
$spare_parts = [
    "Engine Oil" => "engine-oil.jpeg",
    "Brake Pads" => "brake-pads.jpeg",
    "Air Filter" => "air-filter.jpeg",
    "Car Battery" => "battery.jpeg",
    "Tire Set" => "tire-set.jpeg"
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Spare Parts - Car Showroom</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #2e2e2e, #1f1f1f);
    color: #fff;
    margin: 0;
    padding: 0;
}

/* Hero Section */
.hero-wrapper {
    position: relative;
    width: 100%;
    height: 360px;
    overflow: hidden;
}
.hero-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
    filter: brightness(1.05);
    animation: heroFloatZoom 25s linear infinite;
}
@keyframes heroFloatZoom {
    0% { transform: scale(1) translateY(0); }
    25% { transform: scale(1.02) translateY(-10px); }
    50% { transform: scale(1.05) translateY(0); }
    75% { transform: scale(1.02) translateY(10px); }
    100% { transform: scale(1) translateY(0); }
}

/* Hero + heading layout */
.hero-section {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    gap: 30px;
    padding: 40px 20px;
}
.hero-text {
    max-width: 600px;
}
.hero-heading {
    font-weight: 800;
    color: #fff;
    font-size: 1.2rem; 
    line-height: 1.7;
    text-shadow: 2px 2px 6px rgba(0,0,0,0.7);
    margin: 0; 
    padding: 10px 0;
    opacity: 1;
}

/* Spare Parts cards */
.part-card {
    background: white;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 3px 8px rgba(0,0,0,0.05);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    cursor: pointer;
    color: #000;
}
.part-card:hover {
    transform: translateY(-2px) scale(1.015);
    box-shadow: 0 5px 10px rgba(229,1,254,0.1);
}
.part-card img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-radius: 12px 12px 0 0;
}
.btn-orange {
    background: orange;
    color: white;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    transition: 0.3s;
}
.btn-orange:hover {
    background: darkorange;
    animation: bounce 0.4s;
}
@keyframes bounce {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

/* Section Title */
.section-title {
    font-weight: 700;
    margin-bottom: 20px;
    color: #fff;
    text-align: center;
    opacity: 0;
    animation: fadeInDown 1s ease forwards;
}
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Container */
.container.py-5 {
    padding-top: 20px;
    padding-bottom: 50px;
}

/* Responsive adjustments */
@media(max-width: 768px){
    .hero-section { flex-direction: column; padding: 20px 10px; }
    .hero-text { max-width: 100%; font-size: 1rem; text-align: center; }
    .hero-wrapper { height: 280px; }
}
</style>
</head>
<body>

<?php include 'navbar.php'; ?>

<!-- Hero + Heading Section -->
<div class="hero-section">
    <div class="hero-wrapper">
        <img src="assets/images/spareparts-hero.jpeg" alt="Spare Parts Hero" loading="lazy">
    </div>
    <div class="hero-text">
        <p class="hero-heading">
            We bring you a complete range of high-quality spare parts tailored for all makes and models. Our mission is to deliver durable, reliable, and affordable auto parts that keep your car running at peak performance. With trusted products and unbeatable service, we ensure your vehicle stays on the road longer, safer, and stronger.
        </p>
    </div>
</div>

<!-- Spare Parts Section -->
<div class="container py-5" data-aos="fade-up">
    <h2 class="text-center section-title" data-aos="fade-up" data-aos-duration="800">Explore Our Spare Parts</h2>
    <div class="row g-4">
<?php
$sql = "SELECT * FROM spare_parts ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $delay = 100;
    while ($part = $result->fetch_assoc()) {
        $name = htmlspecialchars($part['name']);
        $image = htmlspecialchars($part['image']);
        $imgPath = "admin/uploads/" . $image;

        echo "
        <div class='col-sm-6 col-md-4 col-lg-3' data-aos='fade-up' data-aos-duration='600' data-aos-delay='{$delay}'>
            <div class='part-card h-100 p-3'>
                <img src='{$imgPath}' class='card-img-top' alt='{$name}' loading='lazy'>
                <h5 class='mt-3'>{$name}</h5>
                <p class='text-muted small'>High-quality spare part for your vehicle.</p>
                <button class='btn btn-orange buy-btn' data-part='{$name}'>Buy Now</button>
            </div>
        </div>
        ";
        $delay += 100;
    }
}
?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: true,
    mirror: false
});
</script>
</body>
</html>
