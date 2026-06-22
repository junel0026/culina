<?php
session_start();
require "../config.php";

// Fetch recipes
$recipes = $pdo->query("SELECT id, description FROM foods ORDER BY description")->fetchAll();

// Fetch ingredients
$ingredients = $pdo->query("SELECT id, name FROM new_ingredients ORDER BY name")->fetchAll();

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $recipe_id = $_POST['recipe_id'];
    $ingredient_id = $_POST['ingredient_id'];
    $qty = $_POST['qty'];

    // Insert into recipe_ingredients
    $stmt = $pdo->prepare("
        INSERT INTO recipe_ingredients (recipe_id, ingredient_id, qty)
        VALUES (?, ?, ?)
    ");
    $stmt->execute([$recipe_id, $ingredient_id, $qty]);

    header("Location: admin_ingredients.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Recipe Ingredient</title>
    <link rel="stylesheet" href="admin.css?v=7">
</head>
<body>

<h1 class="admin-title">➕ Add Recipe Ingredient</h1>

<div class="admin-container glass-box">

    <form method="POST" action="add_recipe_ingredients.php" class="glass-form">

        <!-- Recipe Dropdown -->
        <label>Recipe</label>
        <select name="recipe_id" required class="glass-input">
            <option value="">Select Recipe</option>
            <?php foreach ($recipes as $r): ?>
                <option value="<?= $r['id'] ?>">
                    <?= htmlspecialchars($r['description']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Ingredient Dropdown -->
        <label>Ingredient</label>
        <select name="ingredient_id" required class="glass-input">
            <option value="">Select Ingredient</option>
            <?php foreach ($ingredients as $i): ?>
                <option value="<?= $i['id'] ?>">
                    <?= htmlspecialchars($i['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Quantity -->
        <label>Quantity</label>
        <input type="text" name="qty" class="glass-input" placeholder="e.g. 2 cups" required>

        <button type="submit" class="add-btn">Add Ingredient</button>

    </form>

</div>

</body>
</html>
