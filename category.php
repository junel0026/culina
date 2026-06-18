<?php
require "config.php";

$category = $_GET['category'] ?? null;

if (!$category) {
    die("Category not found.");
}

$stmt = $pdo->prepare("
    SELECT foods.*, food_categories.name AS category_name
    FROM foods
    LEFT JOIN food_categories
        ON food_categories.id = foods.category_id
    WHERE foods.category_id = ?
    ORDER BY foods.id DESC
");
$stmt->execute([$category]);
$foods = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        <?= isset($foods[0]) ? $foods[0]['category_name'] : "No Recipes Found" ?>
    </title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<h1>
    <?= isset($foods[0]) ? $foods[0]['category_name'] : "No Recipes Found" ?>
</h1>

<div class="recipe-grid">
    <?php foreach($foods as $f): ?>
<div class="recipe-card">

    <div class="recipe-img">
        <img src="Home Page Photos/<?= $f['image'] ?>" alt="">
    </div>

    <p><?= $f['description'] ?></p>
    <a href="recipe_detail.php?id=<?= $f['id'] ?>" class="view-btn">View Recipe</a>

    <div class="meta">
        <span><?= $f['calories'] ?> kcal</span>
        <span><?= $f['cook_time'] ?> min</span>
    </div>

</div>

    <?php endforeach; ?>
</div>

</body>
</html>
