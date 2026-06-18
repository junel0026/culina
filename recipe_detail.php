<?php
require "config.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Recipe not found.");
}

$stmt = $pdo->prepare("
    SELECT foods.*, food_categories.name AS category_name
    FROM foods
    LEFT JOIN food_categories
        ON food_categories.id = foods.category_id
    WHERE foods.id = ?
");
$stmt->execute([$id]);
$recipe = $stmt->fetch();

if (!$recipe) {
    die("Recipe not found.");
}

$stmtIng = $pdo->prepare("
    SELECT
        i.id,
        i.name,
        i.image,
        ri.qty AS default_qty
    FROM recipe_ingredients ri
    JOIN new_ingredients i ON ri.ingredient_id = i.id
    WHERE ri.recipe_id = ?
");
$stmtIng->execute([$id]);
$new_ingredients = $stmtIng->fetchAll();

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css?v=2">
</head>
<body>

    <div class="recipe-detail-box">

        <!-- IMAGE -->
        <img src="Home Page Photos/<?= $recipe['image'] ?>" class="detail-img">

            <div class="detail-section">
                <h3>Description</h3>
                <p><?= $recipe['description'] ?></p>
            </div>
        <a href="cart.php" class="view-cart-btn">View Cart</a>

        <!-- INGREDIENTS WITH IMAGES -->
        <h3>Ingredients</h3>
        <div class="ingredients-list">

            <?php foreach ($new_ingredients as $ing): ?>
                <div class="ingredient-row" data-id="<?= $ing['id'] ?>">
                    <img src="Home Page Photos/<?= $ing['image'] ?>" class="ingredient-img">
                    <span class="ingredient-name"><?= $ing['name'] ?></span>

                    <div class="ingredient-actions">
                        <button class="ing-qty-btn minus">-</button>
                        <span class="ing-qty-number"><?= $ing['default_qty'] ?></span>
                        <button class="ing-qty-btn plus">+</button>

                        <button class="add-cart-small">Add</button>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>

        <!-- DESCRIPTION + STEPS -->
        <div class="detail-section">

            <h3>Steps</h3>
            <p><?= nl2br($recipe['steps']) ?></p>
        </div>

    </div>
<script src="ingredients.js"></script>
</body>
</html>
