<?php
// add_invoice.php
include 'dashboard.php';  // your dashboard/header
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Create Invoice</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }
        input[type=number], input[type=text], input[type=date] {
            width: 100%;
            box-sizing: border-box;
        }
        .right-align {
            text-align: right;
        }
    </style>
</head>
<body>

<h2>Create Invoice</h2>

<form action="save_invoice.php" method="POST" id="invoiceForm">

    <!-- Invoice Header -->
    <label>Invoice No: <input type="text" name="invoice_no" required /></label><br><br>
    <label>Invoice Date: <input type="date" name="invoice_date" required /></label><br><br>
    <label>Bill To: <input type="text" name="bill_to" required /></label><br><br>
    <label>Ship To: <input type="text" name="ship_to" /></label><br><br>
    <label>Payment Terms: <input type="text" name="payment_terms" /></label><br><br>
    <label>Due Date: <input type="date" name="due_date" /></label><br><br>
    <label>PO Number: <input type="text" name="po_number" /></label><br><br>

    <!-- Invoice Items -->
    <table id="invoiceItemsTable">
        <thead>
            <tr>
                <th>Item Description</th>
                <th>Quantity</th>
                <th>Rate</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <!-- Example 3 rows, you can add more dynamically if needed -->
            <?php for ($i=0; $i<3; $i++): ?>
            <tr>
                <td><input type="text" name="item_desc[]" /></td>
                <td><input type="number" name="quantity[]" min="0" step="1" class="quantity" /></td>
                <td><input type="number" name="rate[]" min="0" step="0.01" class="rate" /></td>
                <td><input type="number" name="amount[]" readonly class="amount right-align" /></td>
            </tr>
            <?php endfor; ?>
        </tbody>
    </table>

    <br>

    <!-- Totals -->
    <table style="width:300px; float:right;">
        <tr>
            <td>Subtotal:</td>
            <td><input type="number" id="subtotal" name="subtotal" readonly class="right-align" value="0.00" /></td>
        </tr>
        <tr>
            <td>Tax:</td>
            <td><input type="number" id="tax" name="tax" min="0" step="0.01" class="right-align" value="0.00" /></td>
        </tr>
        <tr>
            <td>Total:</td>
            <td><input type="number" id="total" name="total" readonly class="right-align" value="0.00" /></td>
        </tr>
        <tr>
            <td>Amount Paid:</td>
            <td><input type="number" id="amount_paid" name="amount_paid" min="0" step="0.01" class="right-align" value="0.00" /></td>
        </tr>
        <tr>
            <td>Balance Due:</td>
            <td><input type="number" id="balance_due" name="balance_due" readonly class="right-align" value="0.00" /></td>
        </tr>
    </table>

    <div style="clear:both;"></div><br>

    <button type="submit">Save Invoice</button>

</form>

<script>
    // Grab all quantity and rate inputs
    const quantities = document.querySelectorAll('.quantity');
    const rates = document.querySelectorAll('.rate');
    const amounts = document.querySelectorAll('.amount');
    const subtotalInput = document.getElementById('subtotal');
    const taxInput = document.getElementById('tax');
    const totalInput = document.getElementById('total');
    const amountPaidInput = document.getElementById('amount_paid');
    const balanceDueInput = document.getElementById('balance_due');

    function calculateAmounts() {
        let subtotal = 0;

        for (let i = 0; i < quantities.length; i++) {
            const qty = parseFloat(quantities[i].value) || 0;
            const rate = parseFloat(rates[i].value) || 0;
            const amount = qty * rate;
            amounts[i].value = amount.toFixed(2);
            subtotal += amount;
        }

        subtotalInput.value = subtotal.toFixed(2);

        // Calculate total with tax
        const tax = parseFloat(taxInput.value) || 0;
        const total = subtotal + tax;
        totalInput.value = total.toFixed(2);

        // Calculate balance due
        const amountPaid = parseFloat(amountPaidInput.value) || 0;
        const balanceDue = total - amountPaid;
        balanceDueInput.value = balanceDue.toFixed(2);
    }

    // Add event listeners
    quantities.forEach(input => {
        input.addEventListener('input', calculateAmounts);
    });

    rates.forEach(input => {
        input.addEventListener('input', calculateAmounts);
    });

    taxInput.addEventListener('input', calculateAmounts);
    amountPaidInput.addEventListener('input', calculateAmounts);

    // Initial calculation
    calculateAmounts();
</script>

</body>
</html>
