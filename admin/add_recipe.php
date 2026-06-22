<?php
session_start();
require "../config.php";

// Fetch categories for dropdown
$catStmt = $pdo->query("SELECT * FROM food_categories ORDER BY name ASC");
$categories = $catStmt->fetchAll();

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $category_id = $_POST['category_id'];
    $description = $_POST['description'];

    // Handle image upload
    $imageName = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    $uploadPath = "food_images/" . $imageName;
    move_uploaded_file($tmp, $uploadPath);

    // Insert into DB
    $stmt = $pdo->prepare("
        INSERT INTO foods (category_id, description, image)
        VALUES (?, ?, ?)
    ");
    $stmt->execute([$category_id, $description, $imageName]);

    header("Location: admin_recipes.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Recipe</title>
    <link rel="stylesheet" href="admin.css?v=3">
</head>
<body>

<h1 class="admin-title">➕ Add New Recipe</h1>

<div class="admin-form-container">

    <form method="POST" enctype="multipart/form-data" class="glass-form">

        <label>Category</label>
        <select name="category_id" required>
            <option value="">Select Category</option>
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
            <?php endforeach; ?>
        </select>

        <label>Description</label>
        <textarea name="description" rows="5" required></textarea>

        <label>Recipe Image</label>
        <input type="file" name="image" accept="image/*" required>

        <button type="submit" class="submit-btn">Save Recipe</button>

    </form>

</div>

</body>
</html>
