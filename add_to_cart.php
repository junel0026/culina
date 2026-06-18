<?php
session_start();

$id = $_POST['id'] ?? null;
$qty = $_POST['qty'] ?? 1;

if (!$id) {
    echo "No ID";
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id] += $qty;
} else {
    $_SESSION['cart'][$id] = $qty;
}

echo "OK";
