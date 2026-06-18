<?php
session_start();
require "../config.php";

if (!isset($_SESSION['user'])) {
    die("Not logged in");
}

$post_id = $_POST['post_id'];

// Fetch post owner
$stmt = $pdo->prepare("SELECT user_id, media_path FROM posts WHERE id = ?");
$stmt->execute([$post_id]);
$post = $stmt->fetch();

if (!$post) {
    die("Post not found");
}

// Check permission
if ($post['user_id'] != $_SESSION['user']['id'] && $_SESSION['user']['is_admin'] != 1) {
    die("You cannot delete this post");
}

// Delete media file
$filepath = "../Home Page Photos/" . $post['media_path'];
if (file_exists($filepath)) {
    unlink($filepath);
}

// Delete post from DB
$stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
$stmt->execute([$post_id]);

header("Location: feed.php");
exit;
