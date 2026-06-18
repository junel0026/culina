<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['is_admin'] != 1) {
    header("Location: index.php");
    exit;
}
require "config.php";

// Fetch all recipes
$stmt = $pdo->query("
    SELECT foods.*, food_categories.name AS category_name
    FROM foods
    LEFT JOIN food_categories
        ON food_categories.id = foods.category_id
    ORDER BY foods.id ASC
");

$recipes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Recipes</title>
    <link rel="stylesheet" href="admin.css?v=3">
</head>
<body>

<h1 class="admin-title">📘 Aromatic Curries</h1>

<div class="admin-container-wide">

    <a href="add_recipe.php" class="add-btn">➕ Add New Recipe</a>

    <table class="glass-table">
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Description</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($recipes as $r): ?>
        <tr>
            <td><?= $r['id'] ?></td>

            <td>
                <img src="Home Page Photos/<?= $r['image'] ?>" class="table-img">
            </td>

            <td><?= $r['description'] ?></td>

            <td><?= $r['category_name'] ?></td>

            <td>
                <div class="action-buttons">
                    <a href="edit_recipe.php?id=<?= $r['id'] ?>" class="edit-btn">Edit</a>
                    <a href="delete_recipe.php?id=<?= $r['id'] ?>" class="delete-btn"
                       onclick="return confirm('Delete this recipe?')">Delete</a>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>

    </table>

</div>

</body>
</html>
