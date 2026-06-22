<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Ingredient</title>
    <link rel="stylesheet" href="admin.css?v=4">
</head>
<body>

<h1 class="admin-title">➕ Add Ingredient</h1>

<div class="admin-form-container">

    <form action="save_ingredient.php" method="POST" enctype="multipart/form-data" class="glass-form">

        <label>Name</label>
        <input type="text" name="name" required>

        <label>Unit</label>
        <input type="text" name="unit" required>

        <label>Image (optional)</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit" class="submit-btn">Add Ingredient</button>

    </form>

</div>

</body>
</html>
