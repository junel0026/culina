<?php
session_start();
require "../config.php";

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: admin_ingredients.php");
    exit;
}

$id   = $_POST['id'] ?? null;   // If empty → add new
$name = $_POST['name'] ?? null;
$unit = $_POST['unit'] ?? null;

if (!$name || !$unit) {
    die("Missing required fields.");
}

// If updating, fetch old image
$oldImage = null;

if ($id) {
    $stmt = $pdo->prepare("SELECT image FROM new_ingredients WHERE id = ?");
    $stmt->execute([$id]);
    $old = $stmt->fetch();

    if ($old) {
        $oldImage = $old['image'];
    }
}

// Handle image upload
$imageName = $oldImage;

if (!empty($_FILES['image']['name'])) {
    $imageName = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp, "../Home Page Photos/" . $imageName);
}

// If ID exists → update
if ($id) {

    $update = $pdo->prepare("
        UPDATE new_ingredients
        SET name = ?, unit = ?, image = ?
        WHERE id = ?
    ");
    $update->execute([$name, $unit, $imageName, $id]);

} else {
    // Otherwise insert new ingredient
    $insert = $pdo->prepare("
        INSERT INTO new_ingredients (name, unit, image)
        VALUES (?, ?, ?)
    ");
    $insert->execute([$name, $unit, $imageName]);
}

header("Location: admin_ingredients.php");
exit;
