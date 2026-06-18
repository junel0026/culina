<?php
session_start();
var_dump($_SESSION);
exit;

if (!isset($_SESSION['user']) || $_SESSION['user']['is_admin'] != 1) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css?v=3">
</head>
<body>

<h1 class="admin-title">👨‍🍳 Admin Dashboard</h1>

<div class="admin-container">

    <a href="admin_recipes.php" class="admin-card">
        <h2>📘 Recipes</h2>
        <p>Manage all recipes</p>
    </a>

    <a href="admin_ingredients.php" class="admin-card">
        <h2>🥕 Ingredients</h2>
    </a>

    <a href="admin_categories.php" class="admin-card">
        <h2>📂 Categories</h2>
    </a>

    <a href="admin_users.php" class="admin-card">
        <h2>👤 Users</h2>
    </a>

    <a href="cart_logs.php" class="admin-card">
        <h2>🛒 Cart Logs</h2>
    </a>

    <a href="logout.php" class="admin-card logout">
        <h2>🚪 Logout</h2>
        <p>Sign out of admin</p>
    </a>

</div>

</body>
</html>
