<?php
session_start();
require "config.php";

/* -----------------------------
   1. FIXED: Correct GET variable
------------------------------ */
$recipe_id = $_GET['recipe_id'] ?? null;

if (!$recipe_id) {
    die("Recipe not found.");
}

/* -----------------------------
   2. Fetch recipe
------------------------------ */
$stmt = $pdo->prepare("SELECT * FROM foods WHERE id = ?");
$stmt->execute([$recipe_id]);
$recipe = $stmt->fetch();

if (!$recipe) {
    die("Recipe not found in database.");
}

/* -----------------------------
   3. Fetch all ingredients (master list)
      FIXED: use new_ingredients table
------------------------------ */
$allIng = $pdo->query("SELECT * FROM new_ingredients ORDER BY name")->fetchAll();

/* -----------------------------
   4. Fetch ingredients already linked to this recipe
      FIXED: JOIN new_ingredients instead of ingredients
------------------------------ */
$stmt2 = $pdo->prepare("
    SELECT
        ri.id AS ri_id,
        i.id AS ingredient_id,
        i.name,
        i.unit,
        i.image,
        ri.qty
    FROM recipe_ingredients ri
    JOIN new_ingredients i ON ri.ingredient_id = i.id
    WHERE ri.recipe_id = ?
");
$stmt2->execute([$recipe_id]);
$recipeIngredients = $stmt2->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Recipe Ingredients</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<h1 class="admin-title">🥣 Edit Ingredients for: <?= $recipe['name'] ?></h1>

<div class="admin-container glass-box">

    <h2>Current Ingredients</h2>

    <?php if (count($recipeIngredients) === 0): ?>
        <p class="empty-text">No ingredients added yet.</p>
    <?php endif; ?>

    <?php foreach ($recipeIngredients as $ri): ?>
        <div class="ingredient-row">

            <img src="Home Page Photos/<?= $ri['image'] ?>" class="ingredient-img-small">

            <strong><?= $ri['name'] ?></strong>

            <form method="POST" action="update_recipe_ingredient.php" class="inline-form">
                <input type="hidden" name="ri_id" value="<?= $ri['ri_id'] ?>">
                <input type="text" name="qty" value="<?= $ri['qty'] ?>" placeholder="Qty">
                <button type="submit" class="edit-btn">Update</button>
            </form>

            <a href="remove_recipe_ingredient.php?ri_id=<?= $ri['ri_id'] ?>"
               class="delete-btn"
               onclick="return confirm('Remove this ingredient?')">
               Remove
            </a>

        </div>
    <?php endforeach; ?>

    <hr>

    <h2>Add New Ingredient</h2>

    <form method="POST" action="add_recipe_ingredient.php" class="glass-form">

        <input type="hidden" name="recipe_id" value="<?= $recipe_id ?>">

        <label>Select Ingredient</label>
        <select name="ingredient_id" required>
            <option value="">-- choose --</option>
            <?php foreach ($allIng as $ing): ?>
                <option value="<?= $ing['id'] ?>">
                    <?= $ing['name'] ?> (<?= $ing['unit'] ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <label>Quantity</label>
        <input type="text" name="qty" placeholder="e.g. 200g">

        <button type="submit" class="submit-btn">Add Ingredient</button>

    </form>

</div>

</body>
</html>
