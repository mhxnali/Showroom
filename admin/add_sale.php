<?php
include 'dashboard.php';
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $invoice_no = $_POST['invoice_no'];
    $bill_to = $_POST['bill_to'];
    $ship_to = $_POST['ship_to'];
    $date = $_POST['date'];
    $payment_terms = $_POST['payment_terms'];
    $due_date = $_POST['due_date'];
    $po_number = $_POST['po_number'];
    $items = json_encode($_POST['items']); // Store items as JSON
    $notes = $_POST['notes'];
    $terms = $_POST['terms'];
    $subtotal = $_POST['subtotal'];
    $tax = $_POST['tax'];
    $total = $_POST['total'];
    $amount_paid = $_POST['amount_paid'];
    $balance_due = $_POST['balance_due'];

    // Removed from_who to match your table columns
    $sql = "INSERT INTO invoices 
        (invoice_no, bill_to, ship_to, date, payment_terms, due_date, po_number, items, notes, terms, subtotal, tax, total, amount_paid, balance_due) 
        VALUES 
        ('$invoice_no', '$bill_to', '$ship_to', '$date', '$payment_terms', '$due_date', '$po_number', '$items', '$notes', '$terms', '$subtotal', '$tax', '$total', '$amount_paid', '$balance_due')";

    if ($conn->query($sql) === TRUE) {
    header("Location: view_invoice.php?id=" . $conn->insert_id);

        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<div class="main-content container mt-4">
    <h2 class="mb-4">Create New Invoice</h2>
    <form method="POST">
        <div class="row">
            <div class="col-md-3">
                <label>Invoice #</label>
                <input type="text" name="invoice_no" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label>Date</label>
                <input type="date" name="date" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label>Payment Terms</label>
                <input type="text" name="payment_terms" class="form-control">
            </div>
            <div class="col-md-3">
                <label>Due Date</label>
                <input type="date" name="due_date" class="form-control">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label>Bill To</label>
                <textarea name="bill_to" class="form-control" rows="2"></textarea>
            </div>
            <div class="col-md-6 mt-3">
                <label>Ship To (optional)</label>
                <textarea name="ship_to" class="form-control" rows="2"></textarea>
            </div>
            <div class="col-md-6 mt-3">
                <label>PO Number</label>
                <input type="text" name="po_number" class="form-control">
            </div>
        </div>

        <h4 class="mt-4">Invoice Items</h4>
        <table class="table table-bordered" id="invoice-items">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Description</th>
                    <th>Rate</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                    <th><button type="button" class="btn btn-sm btn-primary" onclick="addItem()">+</button></th>
                </tr>
            </thead>
            <tbody>
                <tr class="invoice-row">
                    <td><input type="text" name="items[0][item]" class="form-control"></td>
                    <td><input type="text" name="items[0][description]" class="form-control"></td>
                    <td><input type="number" step="0.01" name="items[0][rate]" class="form-control rate"></td>
                    <td><input type="number" name="items[0][quantity]" class="form-control quantity"></td>
                    <td><input type="number" step="0.01" name="items[0][amount]" class="form-control amount" readonly></td>
                    <td><button type="button" class="btn btn-sm btn-danger" onclick="removeItem(this)">x</button></td>
                </tr>
            </tbody>
        </table>

        <div class="row">
            <div class="col-md-6">
                <label>Notes</label>
                <textarea name="notes" class="form-control"></textarea>
            </div>
            <div class="col-md-6">
                <label>Terms</label>
                <textarea name="terms" class="form-control"></textarea>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                <label>Subtotal</label>
                <input type="number" step="0.01" name="subtotal" id="subtotal" class="form-control" readonly>
            </div>
            <div class="col-md-4">
                <label>Tax (%)</label>
                <input type="number" step="0.01" name="tax" id="tax" class="form-control">
            </div>
            <div class="col-md-4">
                <label>Total</label>
                <input type="number" step="0.01" name="total" id="total" class="form-control" readonly>
            </div>
            <div class="col-md-4 mt-3">
                <label>Amount Paid</label>
                <input type="number" step="0.01" name="amount_paid" id="amount_paid" class="form-control">
            </div>
            <div class="col-md-4 mt-3">
                <label>Balance Due</label>
                <input type="number" step="0.01" name="balance_due" id="balance_due" class="form-control" readonly>
            </div>
        </div>

        <br>
        <button type="submit" class="btn btn-success">Save Invoice</button>
    </form>
</div>

<script>
let itemIndex = 1;
function addItem() {
    let table = document.querySelector('#invoice-items tbody');
    let row = document.createElement('tr');
    row.classList.add('invoice-row');
    row.innerHTML = `
        <td><input type="text" name="items[${itemIndex}][item]" class="form-control"></td>
        <td><input type="text" name="items[${itemIndex}][description]" class="form-control"></td>
        <td><input type="number" step="0.01" name="items[${itemIndex}][rate]" class="form-control rate"></td>
        <td><input type="number" name="items[${itemIndex}][quantity]" class="form-control quantity"></td>
        <td><input type="number" step="0.01" name="items[${itemIndex}][amount]" class="form-control amount" readonly></td>
        <td><button type="button" class="btn btn-sm btn-danger" onclick="removeItem(this)">x</button></td>
    `;
    table.appendChild(row);
    itemIndex++;
}

function removeItem(button) {
    button.closest('tr').remove();
    calculateInvoice();
}

function calculateInvoice() {
    let subtotal = 0;
    document.querySelectorAll(".invoice-row").forEach(function (row) {
        let rate = parseFloat(row.querySelector(".rate").value) || 0;
        let qty = parseFloat(row.querySelector(".quantity").value) || 0;
        let amount = rate * qty;
        row.querySelector(".amount").value = amount.toFixed(2);
        subtotal += amount;
    });
    document.querySelector("#subtotal").value = subtotal.toFixed(2);
    let taxPercent = parseFloat(document.querySelector("#tax").value) || 0;
    let taxAmount = subtotal * (taxPercent / 100);
    let total = subtotal + taxAmount;
    document.querySelector("#total").value = total.toFixed(2);
    let amountPaid = parseFloat(document.querySelector("#amount_paid").value) || 0;
    let balanceDue = total - amountPaid;
    document.querySelector("#balance_due").value = balanceDue.toFixed(2);
}

document.addEventListener("input", function (event) {
    if (
        event.target.classList.contains("rate") ||
        event.target.classList.contains("quantity") ||
        event.target.id === "tax" ||
        event.target.id === "amount_paid"
    ) {
        calculateInvoice();
    }
});

document.addEventListener("DOMContentLoaded", calculateInvoice);
</script>
