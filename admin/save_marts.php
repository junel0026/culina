<?php
session_start();
include '../config.php';

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: admin_marts.php");
    exit;
}

// Validate ID
if (!isset($_POST['id']) || empty($_POST['id'])) {
    die("Missing ID");
}

$id = $_POST['id'];

// Get form fields
$name = $_POST['mart_name'] ?? '';
$address = $_POST['address'] ?? '';
$phone = $_POST['phone'] ?? '';
$website = $_POST['website'] ?? '';

// Fetch old image
$stmt = $pdo->prepare("SELECT image FROM marts WHERE id = ?");
$stmt->execute([$id]);
$old = $stmt->fetch();

$imageName = $old['image']; // keep old image

// If new image uploaded
if (!empty($_FILES['image']['name'])) {
    $imageName = uniqid("mart_") . "_" . basename($_FILES['image']['name']);
    $targetPath = "../uploads/marts/" . $imageName;
    move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
}

// Update database
$sql = "UPDATE marts SET mart_name=?, address=?, phone=?, website=?, image=? WHERE id=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$name, $address, $phone, $website, $imageName, $id]);

// Redirect back
header("Location: admin_marts.php");
exit;
