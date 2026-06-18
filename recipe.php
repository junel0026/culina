<?php
session_start();
require 'config.php';
$stmt = $pdo->query("
    SELECT foods.*, food_categories.name AS category_name
    FROM foods
    LEFT JOIN food_categories
        ON food_categories.id = foods.category_id
    ORDER BY foods.id DESC
");
$foods = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Recipes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1 class="page-title">Culina Mm</h1>
<div class="menu_row_for">
        <?php if (isset($_SESSION['user'])): ?>
            <!-- User logged in → show name -->
            <h3>Hello, <?= $_SESSION['user']['name'] ?>!</h3>
        <?php endif; ?>
    <h4><a href="index.php" class="menu_item">Home</a></h4>
    <h4><a href="marts.php" class="menu_item">Business Partners</a></h4>

        <?php if (!isset($_SESSION['user'])): ?>
            <!-- User NOT logged in → show Sign Up -->
            <h4><a href="registration/signup.php" class="menu_item">SignUP</a></h4>
        <?php endif; ?>
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['is_admin'] == 1): ?>
                <h4><a href="admin_recipes.php" class="menu_item">Admin Panel</a></h4>
            <?php endif; ?>

        <?php if (isset($_SESSION['user'])): ?>
            <a href="logout.php" class="menu_item">Logout</a>
        <?php endif; ?>
</div>
<div class="menu_row">
    <h4><a href="category.php?category=1" class="menu_item">ပွဲစာများ</a></h4>
    <h4><a href="category.php?category=2" class="menu_item">အသုပ်</a></h4>
    <h4><a href="category.php?category=3" class="menu_item">Daily Curries</a></h4>
    <h4><a href="category.php?category=4" class="menu_item">Noodles</a></h4>
    <h4><a href="category.php?category=5" class="menu_item">အချိုပွဲများ</a></h4>
    <h4><a href="category.php?category=6" class="menu_item">အကြော်မုန့်များ</a></h4>
        <?php if (isset($_SESSION['user'])): ?>
            <h4><a href="user portal/feed.php" class="menu_item">My Cooking Portal</a></h4>
        <?php endif; ?>
 </div>
<div class="recipe-grid">
    <?php foreach($foods as $f): ?>
        <div class="recipe-card">

            <div class="recipe-img">
                <img src="Home Page Photos/<?= $f['image'] ?>">
            </div>
            <p class="desc"><?= $f['description'] ?></p>
            <a href="recipe_detail.php?id=<?= $f['id'] ?>" class="view-btn">View Recipe</a>

            <div class="meta">
                <span><?= $f['calories'] ?> kcal</span>
                <span><?= $f['cook_time'] ?> min</span>
                <span class="category"><?= $f['category_name'] ?></span>
            </div>

        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
