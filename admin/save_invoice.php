<?php
// save_invoice.php

include 'db.php';  // your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect invoice header data safely (add validation/sanitization as needed)
    $invoice_no = $_POST['invoice_no'] ?? '';
    $invoice_date = $_POST['invoice_date'] ?? null;
    $bill_to = $_POST['bill_to'] ?? '';
    $ship_to = $_POST['ship_to'] ?? '';
    $payment_terms = $_POST['payment_terms'] ?? '';
    $due_date = $_POST['due_date'] ?? null;
    $po_number = $_POST['po_number'] ?? '';
    $subtotal = $_POST['subtotal'] ?? 0;
    $tax = $_POST['tax'] ?? 0;
    $total = $_POST['total'] ?? 0;
    $amount_paid = $_POST['amount_paid'] ?? 0;
    $balance_due = $_POST['balance_due'] ?? 0;

    // Start a transaction for data integrity
    $conn->begin_transaction();

    try {
        // Insert into invoices table
        $stmt = $conn->prepare("INSERT INTO invoices 
            (invoice_no, invoice_date, bill_to, ship_to, payment_terms, due_date, po_number, subtotal, tax, total, amount_paid, balance_due)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssdddddd", 
            $invoice_no, $invoice_date, $bill_to, $ship_to, $payment_terms, $due_date, $po_number, 
            $subtotal, $tax, $total, $amount_paid, $balance_due);
        $stmt->execute();

        // Get the last inserted invoice ID
        $invoice_id = $conn->insert_id;

        // Insert invoice items
        $item_descs = $_POST['item_desc'] ?? [];
        $quantities = $_POST['quantity'] ?? [];
        $rates = $_POST['rate'] ?? [];
        $amounts = $_POST['amount'] ?? [];

        $stmtItem = $conn->prepare("INSERT INTO invoice_items (invoice_id, description, quantity, rate, amount) VALUES (?, ?, ?, ?, ?)");

        for ($i = 0; $i < count($item_descs); $i++) {
            $desc = $item_descs[$i];
            $qty = $quantities[$i];
            $rate = $rates[$i];
            $amount = $amounts[$i];

            // Skip empty items (optional)
            if (empty($desc) && empty($qty) && empty($rate)) {
                continue;
            }

            $stmtItem->bind_param("isidd", $invoice_id, $desc, $qty, $rate, $amount);
            $stmtItem->execute();
        }

        // Commit transaction
        $conn->commit();

        // Redirect or show success message
        header("Location: add_invoice.php?success=1");
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        echo "Error saving invoice: " . $e->getMessage();
    }

} else {
    echo "Invalid request method.";
}
