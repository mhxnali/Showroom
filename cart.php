<?php
session_start();
include 'db.php';

// Quick Buy Now handling: if ?buy_now=ID is passed, add item and go to cart
if (isset($_GET['buy_now'])) {
    $_POST['id'] = intval($_GET['buy_now']);
    $_POST['qty'] = 1;
    $_SERVER['REQUEST_METHOD'] = 'POST';
    include 'add_to_cart.php';
    exit;
}

$cart = $_SESSION['cart'] ?? [];
$total = 0;
foreach ($cart as $c) { $total += $c['price'] * $c['qty']; }
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Your Cart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <h2>Your Cart</h2>
  <?php if (empty($cart)): ?>
    <div class="alert alert-info">Your cart is empty. <a href="index.php">Shop now</a></div>
  <?php else: ?>
    <table class="table table-striped">
      <thead><tr><th>Item</th><th>Unit Price</th><th>Qty</th><th>Amount</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($cart as $id => $item): ?>
          <tr>
            <td><?php echo htmlspecialchars($item['name']); ?></td>
            <td>₹ <?php echo number_format($item['price'],2); ?></td>
            <td>
              <form method="POST" action="update_cart.php" class="d-inline">
                <input type="hidden" name="id" value="<?php echo $id;?>">
                <input type="number" name="qty" value="<?php echo $item['qty'];?>" min="1" style="width:70px" class="form-control d-inline">
                <button class="btn btn-sm btn-secondary mt-1">Update</button>
              </form>
            </td>
            <td>₹ <?php echo number_format($item['price'] * $item['qty'],2); ?></td>
            <td><a class="btn btn-sm btn-danger" href="remove_from_cart.php?id=<?php echo $id; ?>">Remove</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr><td colspan="3" class="text-end"><strong>Total</strong></td><td colspan="2"><strong>₹ <?php echo number_format($total,2); ?></strong></td></tr>
      </tfoot>
    </table>

    <!-- Checkout instructions:
         Option A) Post cart JSON to your add_sale.php (I'll show how below)
         Option B) Manual checkout integration
    -->

    <div class="d-flex gap-2">
      <a class="btn btn-outline-secondary" href="index.php">Continue shopping</a>

      <!-- Example: Prepare form that will submit cart data to add_sale.php -->
      <form method="POST" action="add_sale.php" onsubmit="return prepareCart(this)">
        <!-- These hidden fields should match add_sale.php form names -->
        <input type="hidden" name="invoice_no" value="<?php echo 'INV'.time(); ?>">
        <input type="hidden" name="date" value="<?php echo date('Y-m-d'); ?>">
        <!-- We'll inject items JSON into this field before submit -->
        <input type="hidden" name="items" id="items_field">
        <input type="hidden" name="subtotal" value="<?php echo number_format($total,2,'.',''); ?>" id="subtotal_field">
        <input type="hidden" name="tax" value="0" id="tax_field">
        <input type="hidden" name="total" value="<?php echo number_format($total,2,'.',''); ?>" id="total_field">
        <input type="hidden" name="amount_paid" value="0" id="amount_paid_field">
        <input type="hidden" name="balance_due" value="<?php echo number_format($total,2,'.',''); ?>" id="balance_due_field">
        <button class="btn btn-primary">Proceed to Checkout (Auto-fill invoice)</button>
      </form>

      <!-- Or go to a custom checkout page -->
      <a class="btn btn-success" href="checkout.php">Checkout (custom)</a>
    </div>

    <script>
      function prepareCart(form) {
        // Convert PHP session cart into items JSON
        const cart = <?php echo json_encode($cart); ?>;
        const items = Object.values(cart).map(i => {
          return { item: i.name, description: '', rate: i.price, quantity: i.qty, amount: (i.price * i.qty).toFixed(2) };
        });
        document.getElementById('items_field').value = JSON.stringify(items);
        // If you want to calculate tax here, change tax_field/value accordingly.
        return true; // allow submit
      }
    </script>
  <?php endif; ?>
  <hr>
  <a href="clear_cart.php" class="text-danger">Clear Cart</a>
</div>
</body>
</html>
