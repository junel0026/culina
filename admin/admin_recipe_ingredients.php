<?php
session_start();
require "../config.php";

// Search filter
$search = $_GET['search'] ?? '';

// Fetch recipe ingredients with JOIN
if ($search) {
    $stmt = $pdo->prepare("
       SELECT ri.id, ri.qty,
              r.description AS recipe_name,
              i.name AS ingredient_name
       FROM recipe_ingredients ri
       JOIN foods r ON ri.recipe_id = r.id
       JOIN new_ingredients i ON ri.ingredient_id = i.id
       ORDER BY r.description, i.name

    ");
    $stmt->execute(["%$search%", "%$search%"]);
} else {
    $stmt = $pdo->query("
    SELECT ri.id, ri.qty,
           r.description AS recipe_name,
           i.name AS ingredient_name
    FROM recipe_ingredients ri
    JOIN foods r ON ri.recipe_id = r.id
    JOIN new_ingredients i ON ri.ingredient_id = i.id
    ORDER BY r.description, i.name

    ");
}

$rows = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Recipe Ingredients Dashboard</title>
    <link rel="stylesheet" href="admin.css?v=6">
</head>
<body>

<h1 class="admin-title">🍲 Recipe Ingredients Dashboard</h1>

<div class="header-row">

    <!-- Search -->
    <form method="GET" class="search-form">
        <input type="text" name="search" placeholder="Search recipe or ingredient..."
               value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="search-btn">Search</button>
    </form>

    <!-- Add New -->
    <a href="add_recipe_ingredients.php" class="add-btn">Add Recipe Ingredient</a>
</div>

<div class="admin-container-wide">

    <table class="glass-table">
        <thead>
            <tr>
                <th>Recipe</th>
                <th>Ingredient</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['recipe_name']) ?></td>
                <td><?= htmlspecialchars($row['ingredient_name']) ?></td>
                <td><?= htmlspecialchars($row['qty']) ?></td>

                <td>
                    <div class="action-buttons">
                        <a href="edit_recipe_ingredients.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>

                        <a href="delete_recipe_ingredients.php?id=<?= $row['id'] ?>"
                           class="delete-btn"
                           onclick="return confirm('Delete this recipe ingredient?')">
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
