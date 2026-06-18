<?php
require "config.php";

/*
 * If this file is opened via GET (link, refresh, direct URL),
 * don't die with "Invalid request method" — just send the user back.
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $recipe_id = $_GET['recipe_id'] ?? null;
    if ($recipe_id) {
        header("Location: edit_recipe_ingredients.php?recipe_id=" . $recipe_id);
        exit;
    }

    // Debug fallback: show what actually came in
    echo "This page must be called from the form (POST).<br>";
    echo "REQUEST_METHOD = " . $_SERVER['REQUEST_METHOD'] . "<br>";
    echo "<pre>";
    var_dump($_GET, $_POST);
    echo "</pre>";
    exit;
}

$recipe_id     = $_POST['recipe_id']     ?? null;
$ingredient_id = $_POST['ingredient_id'] ?? null;
$qty           = $_POST['qty']           ?? null;

if (!$recipe_id || !$ingredient_id) {
    die("Missing recipe or ingredient");
}

// Prevent duplicates
$check = $pdo->prepare("
    SELECT COUNT(*)
    FROM recipe_ingredients
    WHERE recipe_id = ? AND ingredient_id = ?
");
$check->execute([$recipe_id, $ingredient_id]);

if ($check->fetchColumn() > 0) {
    // Update instead of duplicate
    $update = $pdo->prepare("
        UPDATE recipe_ingredients
        SET qty = ?
        WHERE recipe_id = ? AND ingredient_id = ?
    ");
    $update->execute([$qty, $recipe_id, $ingredient_id]);
} else {
    // Insert new
    $stmt = $pdo->prepare("
        INSERT INTO recipe_ingredients (recipe_id, ingredient_id, qty)
        VALUES (?, ?, ?)
    ");
    $stmt->execute([$recipe_id, $ingredient_id, $qty]);
}

header("Location: edit_recipe_ingredients.php?recipe_id=" . $recipe_id);
exit;
