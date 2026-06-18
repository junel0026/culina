<?php
session_start();              // 1️⃣ Start session FIRST
require "../config.php";      // 2️⃣ Load DB connection

// 3️⃣ Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: /culina/registration/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload Cooking Post</title>
    <link rel="stylesheet" href="portal.css">
</head>
<body>

<h1>Upload Cooking Video / Image</h1>

<form method="POST" action="save_upload.php" enctype="multipart/form-data" class="glass-form">
    <label>Title</label>
    <input type="text" name="title" required>

    <label>Description</label>
    <textarea name="description" rows="4"></textarea>

    <label>Media (image or video)</label>
    <input type="file" name="media" accept="image/*,video/*" required>

    <button type="submit" class="submit-btn">Upload</button>
</form>

</body>
</html>
