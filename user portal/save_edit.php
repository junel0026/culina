<?php
session_start();
require "../config.php";

if (!isset($_SESSION['user'])) {
    die("Not logged in");
}

$post_id = $_POST['post_id'];
$title = trim($_POST['title']);
$description = trim($_POST['description']);

// Fetch old post
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$post_id]);
$post = $stmt->fetch();

if (!$post) {
    die("Post not found");
}

// Permission check
if ($post['user_id'] != $_SESSION['user']['id'] && $_SESSION['user']['is_admin'] != 1) {
    die("You cannot edit this post");
}

$media_path = $post['media_path'];

// If new media uploaded
if (!empty($_FILES['media']['name'])) {
    $file = $_FILES['media'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','gif','webp','mp4','mov'];

    if (in_array($ext, $allowed)) {
        // Delete old file
        $old_file = "../Home Page Photos/" . $post['media_path'];
        if (file_exists($old_file)) unlink($old_file);

        // Save new file
        $media_path = uniqid("media_") . "." . $ext;
        move_uploaded_file($file['tmp_name'], "../Home Page Photos/" . $media_path);
    }
}

// Update DB
$stmt = $pdo->prepare("UPDATE posts SET title=?, description=?, media_path=? WHERE id=?");
$stmt->execute([$title, $description, $media_path, $post_id]);

header("Location: post.php?id=" . $post_id);
exit;
