<?php
require "config.php";

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: admin_ingredients.php"); exit; }

// Prevent deleting if used in recipes
$check = $pdo->prepare("SELECT COUNT(*) FROM recipe_ingredients WHERE ingredient_id = ?");
$check->execute([$id]);

if ($check->fetchColumn() > 0) {
    die("❌ Cannot delete: Ingredient is used in recipes.");
}

$pdo->prepare("DELETE FROM ingredients WHERE id = ?")->execute([$id]);

header("Location: admin_ingredients.php");
exit;
