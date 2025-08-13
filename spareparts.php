<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spare Parts</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .spareparts-heading {
            position: relative;
            display: inline-block;
            font-weight: bold;
            font-size: 2.5rem;
            background: linear-gradient(90deg, #ff6600, #ff9900);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }
        .spareparts-heading::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: -8px;
            transform: translateX(-50%);
            width: 0%;
            height: 3px;
            background-color: #ff6600;
            transition: width 0.4s ease;
        }
        .spareparts-heading:hover::after { width: 100%; }
        .spareparts-subheading { color: #555; font-size: 1.2rem; margin-bottom: 40px; }
        .spare-card { border: none; transition: transform 0.3s ease, box-shadow 0.3s ease; border-radius: 12px; overflow: hidden; }
        .spare-card:hover { transform: translateY(-8px); box-shadow: 0px 8px 20px rgba(0,0,0,0.2); }
        .spare-card img { height: 200px; object-fit: cover; }
        .btn-buy { background-color: #ff6600; color: white; font-weight: bold; padding: 10px 20px; border-radius: 25px; text-transform: uppercase; }
        .btn-buy:hover { background-color: #e65c00; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container my-5 text-center">
    <h2 class="spareparts-heading">Our Spare Parts</h2>
    <p class="spareparts-subheading">High-quality parts to keep your car running smoothly</p>

    <div class="row">
      <?php include 'db.php';

      $sql = "SELECT * FROM spare_parts ORDER BY id DESC";
      $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($part = $result->fetch_assoc()) {
                // var_dump($part);
            echo '
            <div class="col-md-4 mb-4">
                <div class="card spare-card">
                    <img src="admin/uploads/'.$part["image"].'" class="card-img-top" alt="'.$part["image"].'">
                    <div class="card-body text-center">
                        <h5 class="card-title">'.$part["name"].'</h5>
                        <p class="text-muted">PKR '.$part["name"].'</p>
                        <button 
                            class="btn btn-buy" 
                            data-bs-toggle="modal" 
                            data-bs-target="#buyModal"
                            data-item="'.$part["stock"].'" 
                            data-price="'.$part["price"].'">
                            Buy Now
                        </button>
                    </div>
                </div>
            </div>
            ';
        }
    }
        ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="buyModal" tabindex="-1" aria-labelledby="buyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="buyModalLabel">Buy Spare Part</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="itemName" class="form-label">Item</label>
            <input type="text" id="itemName" class="form-control" readonly>
          </div>
          <div class="mb-3">
            <label for="itemPrice" class="form-label">Price (PKR)</label>
            <input type="text" id="itemPrice" class="form-control" readonly>
          </div>
          <div class="mb-3">
            <label for="buyerName" class="form-label">Your Name</label>
            <input type="text" id="buyerName" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="buyerPhone" class="form-label">Phone Number</label>
            <input type="text" id="buyerPhone" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="buyerAddress" class="form-label">Address</label>
            <textarea id="buyerAddress" class="form-control" rows="2" required></textarea>
          </div>
          <button type="submit" class="btn btn-success w-100">Place Order</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var buyModal = document.getElementById('buyModal');
    buyModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var item = button.getAttribute('data-item');
        var price = button.getAttribute('data-price');
        document.getElementById('itemName').value = item;
        document.getElementById('itemPrice').value = price;
    });
});
</script>

</body>
</html>
