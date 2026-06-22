<?php
session_start();
require "../config.php";

if (!isset($_SESSION['user'])) {
    die("Login required");
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="portal.css?v=3">
</head>
<body>

<div class="profile-glass">
    <h2>Edit Your Profile</h2>

    <form action="save_profile.php" method="POST" enctype="multipart/form-data">

        <label>Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>Change Avatar</label>
        <input type="file" name="avatar" accept="image/*">

        <label>New Password (optional)</label>
        <input type="password" name="password">

        <button type="submit" class="avatar-btn">Save Changes</button>
    </form>
</div>

</body>
</html>
