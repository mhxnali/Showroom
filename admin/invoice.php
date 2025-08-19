<?php
include 'dashboard.php';
include 'db.php';

// --- Guard: need an ID ---
if (!isset($_GET['id'])) {
    die("No invoice ID provided.");
}
$id = (int) $_GET['id'];

// --- Fetch invoice ---
$res = $conn->query("SELECT * FROM invoices WHERE id = {$id} LIMIT 1");
if (!$res || $res->num_rows === 0) {
    die("Invoice not found.");
}
$invoice = $res->fetch_assoc();

// --- Helpers ---
function numval($v) {
    // turn "7,500,000 PKR" or "7500000" into 7500000.00
    return (float) preg_replace('/[^0-9.]/', '', (string)($v ?? '0'));
}
function h($v) {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

// Prefer explicit invoice fields if present; fall back to alternatives
$invoiceNo   = $invoice['invoice_no']   ?? $invoice['id'];
$invoiceDate = $invoice['invoice_date'] ?? $invoice['date'] ?? '';
$customer    = $invoice['bill_to']      ?? $invoice['name'] ?? '';
$type        = $invoice['type']        ?? '';
$pay_type     = $invoice['pay_type']     ?? '';

$itemsJson   = $invoice['items'] ?? '[]';
$itemsArray  = json_decode($itemsJson, true);
if (!is_array($itemsArray)) { $itemsArray = []; }

$grand_total = 0.0;
?>
<div class="main-content">
    <h2>Sales / Invoices</h2>

    <h3>Invoice #<?php echo h($invoiceNo); ?></h3>
    <p><strong>Date:</strong> <?php echo h($invoiceDate); ?></p>
    <p><strong>Customer:</strong> <?php echo h($customer); ?></p>
    <p><strong>Type:</strong> <?php echo h($type); ?></p>
    <p><strong>Payment:</strong> <?php echo h($pay_type); ?></p>
    
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Product</th>
                <th style="width: 90px;">Qty</th>
                <th style="width: 160px;">Unit Price</th>
                <th style="width: 160px;">Line Total</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (count($itemsArray) > 0) {
            foreach ($itemsArray as $item) {
                $name = $item['item'] ?? ($item['product'] ?? 'Item');

                // quantity: default 1
                $qty  = isset($item['quantity']) ? (int)$item['quantity'] : 1;
                if ($qty <= 0) { $qty = 1; }

                // unit price can be in different keys across your data history
                // try price -> rate -> derive from amount/qty -> fallback to invoice.price
                if (isset($item['price'])) {
                    $unit = numval($item['price']);
                } elseif (isset($item['rate'])) {
                    $unit = numval($item['rate']);
                } elseif (isset($item['amount']) && $qty > 0) {
                    $unit = numval($item['amount']) / $qty;
                } else {
                    $unit = numval($invoice['price'] ?? 0);
                }

                $line = $unit * $qty;
                $grand_total += $line;

                echo "<tr>
                        <td>".h($name)."</td>
                        <td>".h($qty)."</td>
                        <td>".number_format($unit, 2)."</td>
                        <td>".number_format($line, 2)."</td>
                      </tr>";
            }
        } else {
            // Fallback: no items JSON — show single row from invoice fields
            $name = $invoice['product'] ?? 'Product';
            $qty  = 1;
            $unit = numval($invoice['price'] ?? 0);
            $line = $unit * $qty;
            $grand_total = $line;

            echo "<tr>
                    <td>".h($name)."</td>
                    <td>1</td>
                    <td>".number_format($unit, 2)."</td>
                    <td>".number_format($line, 2)."</td>
                  </tr>";
        }
        ?>
        </tbody>
    </table>

    <?php
    // Summary block
    $subtotal    = $grand_total;
    $tax         = numval($invoice['tax'] ?? 0);
    $total       = $subtotal + $tax;
    $amount_paid = numval($invoice['amount_paid'] ?? 0);
    $balance_due = $total - $amount_paid;
    ?>
    <div class="mt-4">
        <p><strong>Subtotal:</strong> <?php echo number_format($subtotal, 2); ?></p>
        <p><strong>Tax:</strong> <?php echo number_format($tax, 2); ?></p>
        <p><strong>Total:</strong> <?php echo number_format($total, 2); ?></p>
        <p><strong>Amount Paid:</strong> <?php echo number_format($amount_paid, 2); ?></p>
        <p><strong>Balance Due:</strong> <?php echo number_format($balance_due, 2); ?></p>
    </div>
</div>
