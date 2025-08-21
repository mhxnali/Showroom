<?php
include 'db.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_order'])) {

    $buyerName  = trim($_POST['buyerName'] ?? '');
    $buyerPhone = trim($_POST['buyerPhone'] ?? '');
    $carName    = trim($_POST['carName'] ?? '');
    $carModel   = trim($_POST['carModel'] ?? '');
    $engineCC   = trim($_POST['engineCC'] ?? '');
    $carPrice   = trim($_POST['carPrice'] ?? '');
    $carImage   = trim($_POST['carImage'] ?? '');

    $invoice_no    = 'INV-' . time();
    $invoice_date  = date('Y-m-d');
    $payment_terms = '';
    $due_date      = '';
    $po_number     = '';
    $subtotal      = $carPrice;
    $tax           = 0;
    
    $amount_paid   = $subtotal;
    $balance_due   = 0;
    $date          = date('Y-m-d');
    $types         = 'Car Purchase';
    $pay_type      = $buyerPhone;

    $itemsArray    = [
        [
            "item" => $carName,
            "model" => $carModel,
            "engine_cc" => $engineCC,
            "price" => $carPrice,
            "quantity" => 1,
            "amount" => $carPrice
        ]
    ];
    $itemsJson = json_encode($itemsArray);
    $from_who = '';
    $notes = '';
    $terms = '';

    $stmt = $conn->prepare("INSERT INTO invoices (invoice_no, invoice_date, bill_to, ship_to, payment_terms, due_date, po_number, subtotal, tax, total, amount_paid, balance_due, date, name, types, product, pay_type, price, items, from_who, notes, terms) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "ssssssssddddsssssdssss",
        $invoice_no, $invoice_date, $buyerName, $buyerName, $payment_terms, $due_date, $po_number,
        $subtotal, $tax, $subtotal, $amount_paid, $balance_due, $date,
        $buyerName, $types, $carName, $pay_type, $carPrice, $itemsJson, $from_who, $notes, $terms
    );
    if ($stmt->execute()) {
        $success = "Purchase saved successfully!";
    } else {
        $error = "Error: " . $stmt->error;
    }
}

// Fetch cars
$cars = [];
$sql = "SELECT * FROM cars ORDER BY id DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cars[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Car Showroom</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
<style>
/* Full page background */
body { background-color: #373737ff; }

/* Card image hover zoom */
.card img { 
    height: 200px; 
    object-fit: cover; 
    transition: transform 0.3s; 
    border-radius: 8px;
}
.card:hover img { transform: scale(1.05); }

/* Card gray background */
.card { 
    background-color: #f5f5f5; 
    border-radius: 12px; 
    overflow: hidden; 
    padding: 10px;
}

/* Buy button */
.btn-buy { 
    background-color: #363b37ff; 
    color: white; 
    font-weight: bold; 
    padding: 10px 20px; 
    border-radius: 25px; 
    transition: transform 0.3s; 
}
.btn-buy:hover { 
    background-color: #bfc6c0ff; 
    transform: scale(1.05); 
}

/* Hero Section */
.hero { 
    position: relative; 
    height: 350px; 
    display: flex; 
    flex-direction: column; 
    justify-content: center; 
    align-items: center; 
    overflow: hidden; 
    background: url('assets/images/hero.jpeg') center/cover no-repeat; 
    color: #ffffffff; 
    text-align: center; 
}
.hero-title { font-size: 2.2rem; font-weight: bold; }
.hero-subtitle { font-size: 1.2rem; }
.hero-btn:hover { animation: pulse 1s infinite; }
@keyframes pulse { 0%{ transform: scale(1); } 50%{ transform: scale(1.05); } 100%{ transform: scale(1); } }

/* Sparkles */
.hero-canvas { position: absolute; top:0; left:0; width:100%; height:100%; z-index:1; pointer-events:none; }

/* Cards fade-up animation */
.card-animate { opacity:0; transform: translateY(20px); transition: all 0.8s ease-out; }

/* Featured Cars heading */
h2 { color: #e5e2e2ff;font-size: 2.5rem; font-weight: 800; text-align: center; margin-bottom: 30px; }
</style>
</head>
<body>
<?php include 'navbar.php'; ?>

<!-- Hero Section -->
<section class="hero">
    <canvas id="heroCanvas" class="hero-canvas"></canvas>
    <h1 class="hero-title">Welcome to Our Car Showroom</h1>
    <p class="hero-subtitle">Find your dream car today</p>
    <a href="services.php" class="btn btn-warning hero-btn text-dark">Explore Services</a>
</section>

<div class="container my-5">
    <h2>Featured Cars</h2>

    <?php if(!empty($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if(!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="row">
        <?php foreach($cars as $index => $car): ?>
            <div class="col-md-4 mb-4 card-animate">
                <div class="card shadow-sm text-center">
                    <img src="admin/uploads/<?= $car['image'] ?>" alt="<?= $car['name'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $car['name'] ?></h5>
                        <p class="text-muted"><?= $car['model'] ?> | <?= $car['engine_cc'] ?> cc</p>
                        <p class="fw-bold"><?= $car['price'] ?> PKR</p>
                        <button class="btn btn-buy" 
                            data-bs-toggle="modal" 
                            data-bs-target="#buyModal"
                            data-name="<?= htmlspecialchars($car['name']) ?>"
                            data-model="<?= htmlspecialchars($car['model']) ?>"
                            data-engine="<?= htmlspecialchars($car['engine_cc']) ?>"
                            data-price="<?= htmlspecialchars($car['price']) ?>"
                            data-image="<?= htmlspecialchars($car['image']) ?>">
                            Buy / Book Now
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="buyModal" tabindex="-1" aria-labelledby="buyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
        <input type="hidden" name="place_order" value="1">
        <input type="hidden" name="carName" id="carName">
        <input type="hidden" name="carModel" id="carModel">
        <input type="hidden" name="engineCC" id="engineCC">
        <input type="hidden" name="carPrice" id="carPrice">
        <input type="hidden" name="carImage" id="carImage">
        <div class="modal-header">
          <h5 class="modal-title" id="buyModalLabel">Buy / Book Car</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-center">
            <img id="modalCarImage" src="" class="img-fluid mb-3" style="max-height:200px;">
            <h5 id="modalCarName"></h5>
            <p id="modalCarDetails" class="text-muted"></p>
            <p id="modalCarPrice" class="fw-bold"></p>
            <div class="mb-3">
                <label>Your Name</label>
                <input type="text" name="buyerName" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Phone / Payment Method</label>
                <input type="text" name="buyerPhone" class="form-control" required placeholder="Cash / Card / Online">
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">Submit Order</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Hero sparkles animation
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('heroCanvas');
    const ctx = canvas.getContext('2d');
    canvas.width = canvas.offsetWidth;
    canvas.height = canvas.offsetHeight;

    let particles = [];
    const particleCount = 80;
    for(let i=0; i<particleCount; i++){
        particles.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            radius: Math.random() * 2 + 1,
            speedY: Math.random() * 0.5 + 0.2,
            alpha: Math.random() * 0.5 + 0.5
        });
    }

    function animateParticles(){
        ctx.clearRect(0,0,canvas.width,canvas.height);
        particles.forEach(p=>{
            ctx.beginPath();
            ctx.arc(p.x,p.y,p.radius,0,Math.PI*2);
            ctx.fillStyle = `rgba(255,255,255,${p.alpha})`;
            ctx.fill();
            p.y -= p.speedY;
            if(p.y < 0) p.y = canvas.height;
        });
        requestAnimationFrame(animateParticles);
    }
    animateParticles();

    window.addEventListener('resize', () => {
        canvas.width = canvas.offsetWidth;
        canvas.height = canvas.offsetHeight;
    });

    // Modal populate
    const buyModal = document.getElementById('buyModal');
    buyModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        document.getElementById('carName').value = button.getAttribute('data-name');
        document.getElementById('carModel').value = button.getAttribute('data-model');
        document.getElementById('engineCC').value = button.getAttribute('data-engine');
        document.getElementById('carPrice').value = button.getAttribute('data-price');
        document.getElementById('carImage').value = button.getAttribute('data-image');

        document.getElementById('modalCarName').innerText = button.getAttribute('data-name');
        document.getElementById('modalCarDetails').innerText = button.getAttribute('data-model') + " | " + button.getAttribute('data-engine') + " cc";
        document.getElementById('modalCarPrice').innerText = button.getAttribute('data-price') + " PKR";
        document.getElementById('modalCarImage').src = "admin/uploads/" + button.getAttribute('data-image');
    });

    // Scroll animation for cards
    const cards = document.querySelectorAll('.card-animate');
    function checkCards() {
        const triggerBottom = window.innerHeight * 0.9;
        cards.forEach(card => {
            const cardTop = card.getBoundingClientRect().top;
            if(cardTop < triggerBottom){
                card.style.opacity = 1;
                card.style.transform = 'translateY(0)';
            }
        });
    }
    window.addEventListener('scroll', checkCards);
    checkCards();
});
</script>
</body>
</html>
