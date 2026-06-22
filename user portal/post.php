<?php
session_start();
require "../config.php";

// Validate post ID
$post_id = $_GET['id'] ?? null;
if (!$post_id) {
    die("Post not found");
}

// Fetch post + user info
$stmt = $pdo->prepare("
    SELECT p.*, u.name, u.avatar
    FROM posts p
    JOIN users u ON p.user_id = u.id
    WHERE p.id = ?
");
$stmt->execute([$post_id]);
$post = $stmt->fetch();

if (!$post) {
    die("Post not found");
}

// Fetch comments
$cstmt = $pdo->prepare("
    SELECT c.*, u.name, u.avatar
    FROM comments c
    JOIN users u ON c.user_id = u.id
    WHERE c.post_id = ?
    ORDER BY c.created_at ASC
");
$cstmt->execute([$post_id]);
$comments = $cstmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($post['title']) ?></title>
    <link rel="stylesheet" href="portal.css">
</head>
<body>

<a href="feed.php">← Back to feed</a>

<div class="post-full">

    <?php if ($post['media_type'] === 'video'): ?>
        <video src="../Home Page Photos/<?= htmlspecialchars($post['media_path']) ?>" controls></video>
    <?php else: ?>
        <img src="../Home Page Photos/<?= htmlspecialchars($post['media_path']) ?>" alt="">
    <?php endif; ?>

    <h1><?= htmlspecialchars($post['title']) ?></h1>
    <p><?= nl2br(htmlspecialchars($post['description'])) ?></p>

    <div class="post-user">
        <?php if ($post['avatar']): ?>
            <img src="../Home Page Photos/<?= htmlspecialchars($post['avatar']) ?>" class="mini-avatar">
        <?php endif; ?>
        <span>by <?= htmlspecialchars($post['name']) ?></span>
    </div>
</div>

<hr>

<h2>Comments</h2>

<div class="comments">
    <?php if (count($comments) === 0): ?>
        <p>No comments yet.</p>
    <?php endif; ?>

    <?php foreach ($comments as $c): ?>
        <div class="comment">
            <div class="comment-header">
                <?php if ($c['avatar']): ?>
                    <img src="../Home Page Photos/<?= htmlspecialchars($c['avatar']) ?>" class="mini-avatar">
                <?php endif; ?>
                <strong><?= htmlspecialchars($c['name']) ?></strong>
            </div>
            <p><?= nl2br(htmlspecialchars($c['content'])) ?></p>
        </div>
    <?php endforeach; ?>
</div>

<?php if (isset($_SESSION['user'])): ?>
    <form method="POST" action="add_comment.php" class="glass-form">
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <textarea name="content" rows="3" placeholder="Write a comment..." required></textarea>
        <button type="submit" class="submit-btn">Comment</button>
    </form>
<?php else: ?>
    <p><a href="../login.php">Log in</a> to comment.</p>
<?php endif; ?>

<!-- ⭐ DELETE BUTTON -->
<?php if (isset($_SESSION['user']) && ($post['user_id'] == $_SESSION['user']['id'] || $_SESSION['user']['is_admin'] == 1)): ?>
    <form action="delete_post.php" method="POST" onsubmit="return confirm('Delete this post?');">
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <button type="submit" class="delete-btn">Delete Post</button>
    </form>

    <a href="edit_post.php?id=<?= $post['id'] ?>" class="edit-btn">Edit Post</a>
<?php endif; ?>

</body>
</html>
