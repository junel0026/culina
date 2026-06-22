<?php
session_start();
require "../config.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: admin_recipes.php");
    exit;
}

// Fetch recipe to delete image
$stmt = $pdo->prepare("SELECT image FROM foods WHERE id = ?");
$stmt->execute([$id]);
$recipe = $stmt->fetch();

// Delete image file (optional but recommended)
if ($recipe && file_exists("food_images/" . $recipe['image'])) {
    unlink("food_images/" . $recipe['image']);
}

// Delete recipe from DB
$delete = $pdo->prepare("DELETE FROM foods WHERE id = ?");
$delete->execute([$id]);

header("Location: admin_recipes.php");
exit;
