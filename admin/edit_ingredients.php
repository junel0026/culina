<?php
session_start();
require "../config.php";

// Get ingredient ID
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: ingredients_dashboard.php");
    exit;
}

// Fetch ingredient
$stmt = $pdo->prepare("SELECT * FROM new_ingredients WHERE id = ?");
$stmt->execute([$id]);
$ingredient = $stmt->fetch();

if (!$ingredient) {
    die("Ingredient not found.");
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $unit = $_POST['unit'];

    // If new image uploaded
    if (!empty($_FILES['image']['name'])) {
        $imageName = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, "../Home Page Photos/" . $imageName);
    } else {
        $imageName = $ingredient['image']; // keep old image
    }

    // Update DB
    $update = $pdo->prepare("
        UPDATE new_ingredients
        SET name = ?, unit = ?, image = ?
        WHERE id = ?
    ");
    $update->execute([$name, $unit, $imageName, $id]);

    header("Location: ingredients_dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Ingredient</title>
    <link rel="stylesheet" href="admin.css?v=4">
</head>
<body>

<h1 class="admin-title">✏️ Edit Ingredient</h1>

<div class="admin-form-container">

 <form action="update_ingredients.php" method="POST" enctype="multipart/form-data" class="glass-form">

     <!-- Hidden ID field (required for update) -->
     <input type="hidden" name="id" value="<?= $ingredient['id'] ?>">

     <label>Name</label>
     <input type="text" name="name" value="<?= htmlspecialchars($ingredient['name']) ?>" required>

     <label>Unit</label>
     <input type="text" name="unit" value="<?= htmlspecialchars($ingredient['unit']) ?>" required>

     <label>Current Image</label>
     <?php if ($ingredient['image']): ?>
         <img src="../Home Page Photos/<?= $ingredient['image'] ?>" class="edit-img-preview">
     <?php else: ?>
         <p>No image uploaded</p>
     <?php endif; ?>

     <label>Change Image (optional)</label>
     <input type="file" name="image" accept="image/*">

     <button type="submit" class="submit-btn">Update Ingredient</button>

 </form>


</div>

</body>
</html>
