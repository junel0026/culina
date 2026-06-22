<?php
session_start();
require "../config.php";

// Redirect if not logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../signup.php");
    exit;
}

$user = $_SESSION['user'];

// Fetch posts of the logged-in user
$stmt = $pdo->prepare("
    SELECT p.*, u.name, u.avatar
    FROM posts p
    JOIN users u ON p.user_id = u.id
    WHERE p.user_id = :uid
    ORDER BY p.created_at DESC
");
$stmt->execute([':uid' => $user['id']]);
$posts = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($user['name']) ?>'s Cooking Feed</title>
    <link rel="stylesheet" href="portal.css?v=4">
</head>
<body>
    <a href="../index.php" class="home-btn">Home Page</a>
<!-- ⭐ GLASS PROFILE HEADER -->
<div class="profile-glass">
    <?php if (!empty($user['avatar'])): ?>
        <img src="../Home Page Photos/<?= htmlspecialchars($user['avatar']) ?>" class="avatar">
    <?php else: ?>
        <div class="no-avatar">
            <p>You don’t have an avatar yet</p>
            <a href="avatar_upload.php" class="avatar-btn">Create Avatar</a>
        </div>
    <?php endif; ?>

    <h1><?= htmlspecialchars($user['name']) ?>'s Cooking Feed</h1>

    <a href="edit_profile.php" class="avatar-btn">Edit Profile</a>

</div>

<a href="upload.php" class="add-btn">Upload New</a>

<!-- ⭐ FEED -->
<div class="feed">
    <?php foreach ($posts as $post): ?>
        <div class="post-card">
            <a href="post.php?id=<?= $post['id'] ?>">
                <?php if ($post['media_type'] === 'video'): ?>
                    <video src="../Home Page Photos/<?= $post['media_path'] ?>" controls></video>
                <?php else: ?>
                    <img src="../Home Page Photos/<?= $post['media_path'] ?>" alt="">
                <?php endif; ?>
            </a>

            <div class="post-info">
                <strong><?= htmlspecialchars($post['title']) ?></strong>
                <p><?= nl2br(htmlspecialchars($post['description'])) ?></p>

                <div class="post-user">
                    <span>by <?= htmlspecialchars($post['name']) ?></span>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
