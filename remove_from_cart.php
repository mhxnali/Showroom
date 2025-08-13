<?php
session_start();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id && isset($_SESSION['cart'][$id])) {
    unset($_SESSION['cart'][$id]);
}
header('Location: cart.php');
exit;
