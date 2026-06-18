<?php
session_start();
require "config.php";

// Fetch all ingredients
$stmt = $pdo->query("SELECT * FROM new_ingredients ORDER BY name");
$ingredients = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ingredients Dashboard</title>
    <link rel="stylesheet" href="admin.css?v=2">
</head>
<body>

<h1 class="admin-title">🥕 Ingredients Dashboard</h1>

<div class="admin-container glass-box">

    <div class="header-row">
        <a href="add_recipe_ingredients.php" class="add-btn">Add Ingredient</a>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Unit</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($ingredients as $ing): ?>
            <tr>
                <td>
                    <?php if ($ing['image']): ?>
                        <img src="Home Page Photos/<?= $ing['image'] ?>" class="table-img">
                    <?php else: ?>
                        <span>No Image</span>
                    <?php endif; ?>
                </td>

                <td><?= $ing['name'] ?></td>
                <td><?= $ing['unit'] ?></td>

                <td>
                    <div class="action-buttons">
                        <a href="edit_ingredients.php?recipe_id=<?= $recipe_id ?>&id=<?= $ing['id'] ?>" class="edit-btn">Edit</a>
                        <a href="delete_ingredients.php?id=<?= $ing['id'] ?>"
                           class="delete-btn"
                           onclick="return confirm('Delete this ingredient?')">
                           Delete
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

</div>

</body>
</html>
