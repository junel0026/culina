<?php
require "config.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Ingredient not found.");
}

// Fetch ingredient
$stmt = $pdo->prepare("SELECT * FROM ingredients WHERE id = ?");
$stmt->execute([$id]);
$ing = $stmt->fetch();

if (!$ing) {
    die("Ingredient not found.");
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $unit = $_POST['unit'];

    // Handle image upload
    $image = $ing['image']; // keep old image by default

    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . $_FILES['image']['name'];
        $target = "Home Page Photos/" . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image = $imageName;
        }
    }

    // Update ingredient
    $update = $pdo->prepare("
        UPDATE ingredients
        SET name = ?, unit = ?, image = ?
        WHERE id = ?
    ");
    $update->execute([$name, $unit, $image, $id]);

    header("Location: admin_ingredients.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Ingredient</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<h1 class="admin-title">✏️ Edit Ingredient</h1>

<div class="admin-container glass-box">

    <form method="POST" enctype="multipart/form-data" class="glass-form">

        <label>Name</label>
        <input type="text" name="name" value="<?= $ing['name'] ?>" required>

        <label>Unit</label>
        <input type="text" name="unit" value="<?= $ing['unit'] ?>" required>

        <label>Current Image</label>
        <?php if ($ing['image']): ?>
            <img src="Home Page Photos/<?= $ing['image'] ?>" class="table-img">
        <?php else: ?>
            <p>No image uploaded.</p>
        <?php endif; ?>

        <label>Upload New Image (optional)</label>
        <input type="file" name="image">

        <button type="submit" class="submit-btn">Save Changes</button>

    </form>

</div>

</body>
</html>
