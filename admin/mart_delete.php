<?php
include '../config.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Invalid ID");
}

// Get image name
$stmt = $pdo->prepare("SELECT image FROM marts WHERE id = ?");
$stmt->execute([$id]);
$mart = $stmt->fetch();

// Delete image file
if ($mart && $mart['image']) {
    $imagePath = "../uploads/marts/" . $mart['image'];
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
}

// Delete DB row
$stmt = $pdo->prepare("DELETE FROM marts WHERE id = ?");
$stmt->execute([$id]);

// Redirect back
header("Location: admin_marts.php");
exit;
