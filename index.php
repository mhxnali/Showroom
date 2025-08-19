
<?php
include 'db.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_order'])) {

    // Get user input
    $buyerName  = trim($_POST['buyerName'] ?? '');
    $buyerPhone = trim($_POST['buyerPhone'] ?? '');
    $carName    = trim($_POST['carName'] ?? '');
    $carModel   = trim($_POST['carModel'] ?? '');
    $engineCC   = trim($_POST['engineCC'] ?? '');
    $carPrice   = trim($_POST['carPrice'] ?? '');
    $carImage   = trim($_POST['carImage'] ?? '');

    // Prepare invoice variables
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
    $pay_type      = $buyerPhone; // storing phone/payment method
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

    // Prepare and execute insert
    $stmt = $conn->prepare("INSERT INTO invoices (invoice_no, invoice_date, bill_to, ship_to, payment_terms, due_date, po_number, subtotal, tax, total, amount_paid, balance_due, date, name, types, product, pay_type, price, items, from_who, notes, terms) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "ssssssssddddsssssdssss",
        $invoice_no, $invoice_date, $buyerName, $buyerName, $payment_terms, $due_date, $po_number,
        $subtotal, $tax, $total, $amount_paid, $balance_due, $date,
        $buyerName, $types, $carName, $pay_type, $carPrice, $itemsJson, $from_who, $notes, $terms
    );
    if ($stmt->execute()) {
        $success = "Purchase saved successfully!";
    } else {
        $error = "Error: " . $stmt->error;
    }
}

// Fetch cars from database
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
.card img { height: 200px; object-fit: cover; transition: transform 0.3s; }
.card:hover img { transform: scale(1.05); }
.btn-buy { background-color: #28a745; color: white; font-weight: bold; padding: 10px 20px; border-radius: 25px; }
.btn-buy:hover { background-color: #218838; }
</style>
</head>
<body>
<?php include 'navbar.php'; ?>
<!-- Hero Section -->
<section class="hero text-center text-white" 
         style="position: relative; height: 300px; display: flex; flex-direction: column; justify-content: center; background: url('assets/images/hero.jpeg') center/cover;">
    <div style="position:absolute; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.4);"></div>
    <h1 style="position:relative; z-index:1;">Welcome to Our Showroom</h1>
    <p style="position:relative; z-index:1;">Find your dream car today</p>
    <a href="services.php" class="btn btn-warning text-dark" style="position:relative; z-index:1;">Explore Services</a>
</section>


<div class="container my-5">
    <h2 class="mb-4 text-center">Featured Cars</h2>

    <?php if(!empty($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if(!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="row">
        <?php foreach($cars as $car): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <img src="admin/uploads/<?= $car['image'] ?>" class="card-img-top" alt="<?= $car['name'] ?>">
                    <div class="card-body text-center">
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
document.addEventListener('DOMContentLoaded', function() {
    var buyModal = document.getElementById('buyModal');

    buyModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var name = button.getAttribute('data-name');
        var model = button.getAttribute('data-model');
        var engine = button.getAttribute('data-engine');
        var price = button.getAttribute('data-price');
        var image = button.getAttribute('data-image');

        document.getElementById('carName').value = name;
        document.getElementById('carModel').value = model;
        document.getElementById('engineCC').value = engine;
        document.getElementById('carPrice').value = price;
        document.getElementById('carImage').value = image;

        document.getElementById('modalCarName').innerText = name;
        document.getElementById('modalCarDetails').innerText = model + " | " + engine + " cc";
        document.getElementById('modalCarPrice').innerText = price + " PKR";
        document.getElementById('modalCarImage').src = "admin/uploads/" + image;
    });
});
</script>

</body>
</html>
