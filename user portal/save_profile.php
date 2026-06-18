<?php
session_start();
require "../config.php";

if (!isset($_SESSION['user'])) {
    die("Login required");
}

$user_id = $_SESSION['user']['id'];
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = $_POST['password'];

// Handle avatar upload if provided
$avatar_filename = $_SESSION['user']['avatar'];

if (!empty($_FILES['avatar']['name'])) {
    $file = $_FILES['avatar'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','gif','webp'];

    if (in_array($ext, $allowed)) {
        $avatar_filename = uniqid('avatar_') . '.' . $ext;
        $target = __DIR__ . "/../Home Page Photos/" . $avatar_filename;
        move_uploaded_file($file['tmp_name'], $target);
    }
}

// Update password only if user typed one
if (!empty($password)) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE users SET name=?, email=?, avatar=?, password=? WHERE id=?");
    $stmt->execute([$name, $email, $avatar_filename, $hashed, $user_id]);
} else {
    $stmt = $pdo->prepare("UPDATE users SET name=?, email=?, avatar=? WHERE id=?");
    $stmt->execute([$name, $email, $avatar_filename, $user_id]);
}

// Update session
$_SESSION['user']['name'] = $name;
$_SESSION['user']['email'] = $email;
$_SESSION['user']['avatar'] = $avatar_filename;

header("Location: feed.php");
exit;
