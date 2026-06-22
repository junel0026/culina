<?php
session_start();
require "../config.php";

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ingredients_dashboard.php");
    exit;
}

$name = $_POST['name'] ?? null;
$unit = $_POST['unit'] ?? null;

if (!$name || !$unit) {
    die("Missing required fields.");
}

// Handle image upload
$imageName = null;

if (!empty($_FILES['image']['name'])) {
    $imageName = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp, "../Home Page Photos/" . $imageName);
}

// Insert new ingredient
$insert = $pdo->prepare("
    INSERT INTO new_ingredients (name, unit, image)
    VALUES (?, ?, ?)
");
$insert->execute([$name, $unit, $imageName]);

header("Location: ingredients_dashboard.php");
exit;
