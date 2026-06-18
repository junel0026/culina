<?php
session_start();
require "../config.php";

if (!isset($_SESSION['user'])) {
    die("Not logged in");
}

$post_id = $_GET['id'] ?? null;
if (!$post_id) {
    die("Post not found");
}

// Fetch post
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
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
    <link rel="stylesheet" href="portal.css">
</head>
<body>

<h1>Edit Post</h1>

<form action="save_edit.php" method="POST" enctype="multipart/form-data" class="glass-form">
    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">

    <label>Title</label>
    <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>

    <label>Description</label>
    <textarea name="description" rows="5" required><?= htmlspecialchars($post['description']) ?></textarea>

    <label>Change Media (optional)</label>
    <input type="file" name="media">

    <button type="submit" class="submit-btn">Save Changes</button>
</form>

</body>
</html>
