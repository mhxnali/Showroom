<?php
// Purely front-end example
$services = [
    "Oil Change" => "oil-change.jpeg",
    "Tire Replacement" => "tire-replacement.jpeg",
    "Car Wash" => "car-wash.jpeg",
    "Battery Check" => "battery-check.jpeg",
    "Brake Service" => "brake-service.jpeg",
    "Engine Tune-Up" => "engine-tuneup.jpeg",
    "AC Repair" => "air-conditioning.jpeg",
    "Custom Paint Job" => "paint-job.jpeg",
    "Wheel Alignment" => "wheel-alignment.jpeg",
    "Car Detailing" => "detailing.jpeg"
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services - Car Showroom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .service-card {
            background: white;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            cursor: pointer;
        }
        .service-card:hover {
            transform: translateY(-5px) scale(1.03);
            box-shadow: 0 10px 25px rgba(229, 1, 254, 0.4);
        }
        .service-card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 8px 8px 0 0;
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
        }
    </style>
</head>
<body class="bg-light">

<?php include 'navbar.php'; ?>

<!-- Services Section -->
<div class="container py-5">
    <h1 class="text-center mb-4">Explore Our Premium Services</h1>
    <div class="row g-4">
<?php
include 'db.php';

$sql = "SELECT * FROM services ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($part = $result->fetch_assoc()) {
        $name = htmlspecialchars($part['name']);
        $image = htmlspecialchars($part['image']);
        $imgPath = "admin/uploads/" . $image; // adjust path if needed

        echo "
        <div class='col-sm-6 col-md-4 col-lg-3'>
            <div class='service-card h-100 p-3'>
                <img src='{$imgPath}' class='card-img-top' alt='{$name}'>
                <h5 class='mt-3'>{$name}</h5>
                <p class='text-muted small'>High-quality service for your vehicle’s needs.</p>
                <button class='btn btn-orange book-btn' data-service='{$name}'>Book Now</button>
            </div>
        </div>
        ";
    }
}
?>

        ?>
    </div>
</div>

<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-3 shadow">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">Book a Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="text" class="form-control mb-2" placeholder="Full Name" required>
                    <input type="tel" class="form-control mb-2" placeholder="Phone Number" required>
                    <input type="email" class="form-control mb-2" placeholder="Email Address" required>
                    <select id="serviceDropdown" class="form-select mb-2">
                        <?php
                        foreach ($services as $name => $image) {
                            echo "<option value='$name'>$name</option>";
                        }
                        ?>
                    </select>
                    <input type="date" class="form-control mb-2" required>
                    <input type="time" class="form-control mb-3" required>
                    <button type="submit" class="btn btn-orange w-100">Confirm Booking</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const bookingModal = new bootstrap.Modal(document.getElementById('bookingModal'));
    const serviceDropdown = document.getElementById("serviceDropdown");
    document.querySelectorAll(".book-btn").forEach(button => {
        button.addEventListener("click", function() {
            serviceDropdown.value = this.getAttribute("data-service");
            bookingModal.show();
        });
    });
</script>
</body>
</html>
