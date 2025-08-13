<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$qty = isset($_POST['qty']) ? max(1,intval($_POST['qty'])) : 1;

// If id = 0 (placeholder), just redirect
if ($id <= 0) {
    $_SESSION['flash'] = "Placeholder item, can't add.";
    header('Location: index.php');
    exit;
}

// Fetch car details from DB (safe check)
$stmt = $conn->prepare("SELECT id, name, price FROM cars WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    $_SESSION['flash'] = "Item not found.";
    header('Location: index.php');
    exit;
}
$item = $res->fetch_assoc();

// initialize cart
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

// If item exists, increase qty
if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['qty'] += $qty;
} else {
    $_SESSION['cart'][$id] = [
        'id' => $item['id'],
        'name' => $item['name'],
        'price' => floatval($item['price']),
        'qty' => $qty
    ];
}

header('Location: ' . ($_POST['redirect'] ?? 'index.php'));
exit;
