<?php
session_start();
require "../config.php";

if (!isset($_SESSION['user_id'])) {
    die("Login required");
}

// ⭐ Check if file exists
if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
    die("No file uploaded");
}

$file = $_FILES['avatar'];

$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$allowed = ['jpg','jpeg','png','gif','webp'];

if (!in_array($ext, $allowed)) {
    die("Invalid file type");
}

$filename = uniqid('avatar_') . '.' . $ext;
$target = __DIR__ . "/../Home Page Photos/" . $filename;

move_uploaded_file($file['tmp_name'], $target);

// ⭐ Update DB
$stmt = $pdo->prepare("UPDATE users SET avatar = ? WHERE id = ?");
$stmt->execute([$filename, $_SESSION['user_id']]);

// ⭐ Update session
$_SESSION['user']['avatar'] = $filename;

header("Location: feed.php");
exit;
