<?php
session_start();
require "../config.php";

// Fetch all ingredients
$search = $_GET['search'] ?? '';

if ($search) {
    $stmt = $pdo->prepare("SELECT * FROM new_ingredients
                           WHERE name LIKE ? OR unit LIKE ?
                           ORDER BY name");
    $stmt->execute(["%$search%", "%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM new_ingredients ORDER BY name");
}

$ingredients = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Ingredients Dashboard</title>
    <link rel="stylesheet" href="admin.css?v=5">
</head>
<body>

<h1 class="admin-title">🥕 Ingredients Dashboard</h1>
    <div class="header-row">
        <a href="add_recipe_ingredients.php" class="add-btn">Add Ingredient</a>
    </div>
<div class="header-row">
    <form method="GET" class="search-form">
        <input type="text" name="search" placeholder="Search ingredients..."
               value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <button type="submit" class="search-btn">Search</button>
    </form>
</div>


<div class="admin-container glass-box">


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
                        <img src="../Home Page Photos/<?= $ing['image'] ?>" class="table-img">
                    <?php else: ?>
                        <span>No Image</span>
                    <?php endif; ?>
                </td>

                <td><?= htmlspecialchars($ing['name']) ?></td>
                <td><?= htmlspecialchars($ing['unit']) ?></td>

                <td>
                    <div class="action-buttons">
                        <!-- FIXED: Removed recipe_id (undefined) -->
                        <a href="edit_ingredients.php?id=<?= $ing['id'] ?>" class="edit-btn">Edit</a>

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
