<?php
session_start();
require "config.php";

// Get recipe ID
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: admin_recipes.php");
    exit;
}

// Fetch recipe
$stmt = $pdo->prepare("SELECT * FROM foods WHERE id = ?");
$stmt->execute([$id]);
$recipe = $stmt->fetch();

// Fetch categories
$catStmt = $pdo->query("SELECT * FROM food_categories ORDER BY name ASC");
$categories = $catStmt->fetchAll();

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];

    // If new image uploaded
    if (!empty($_FILES['image']['name'])) {
        $imageName = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, "food_images/" . $imageName);
    } else {
        $imageName = $recipe['image']; // keep old image
    }

    // Update DB
    $update = $pdo->prepare("
        UPDATE foods
        SET category_id = ?, description = ?, image = ?
        WHERE id = ?
    ");
    $update->execute([$category_id, $description, $imageName, $id]);

    header("Location: admin_recipes.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Recipe</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<h1 class="admin-title">✏️ Edit Recipe</h1>

<div class="admin-form-container">

    <form method="POST" enctype="multipart/form-data" class="glass-form">

        <label>Category</label>
        <select name="category_id" required>
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['id'] ?>"
                    <?= $c['id'] == $recipe['category_id'] ? 'selected' : '' ?>>
                    <?= $c['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Description</label>
        <textarea name="description" rows="5" required><?= $recipe['description'] ?></textarea>

        <label>Current Image</label>
        <img src="Home Page Photos/<?= $recipe['image'] ?>" class="edit-img-preview">

        <label>Change Image (optional)</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit" class="submit-btn">Update Recipe</button>

    </form>

</div>

</body>
</html>
