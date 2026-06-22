<?php
session_start();
require "../config.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request");
}

$post_id = $_POST['post_id'] ?? null;
$content = trim($_POST['content'] ?? '');

if (!$post_id || $content === '') {
    die("Missing data");
}

$stmt = $pdo->prepare("
    INSERT INTO comments (post_id, user_id, content)
    VALUES (?, ?, ?)
");
$stmt->execute([$post_id, $_SESSION['user_id'], $content]);

header("Location: post.php?id=" . $post_id);
exit;
