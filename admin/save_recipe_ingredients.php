<?php
session_start();
require "../config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $recipe_id = $_POST['recipe_id'];
    $ingredient_id = $_POST['ingredient_id'];
    $qty = $_POST['qty'];

    // Insert into recipe_ingredients table
    $stmt = $pdo->prepare("
        INSERT INTO recipe_ingredients (recipe_id, ingredient_id, qty)
        VALUES (?, ?, ?)
    ");
    $stmt->execute([$recipe_id, $ingredient_id, $qty]);

    // Redirect back to dashboard
    header("Location: admin_ingredients.php");
    exit;
}
?>
