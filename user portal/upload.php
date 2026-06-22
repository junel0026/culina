<?php
session_start();              // 1️⃣ Start session FIRST
require "../config.php";      // 2️⃣ Load DB connection

// 3️⃣ Check login
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
    <input type="text" name="title">

    <label>Description</label>
    <textarea name="description" rows="4"></textarea>

    <label>Media (image or video)</label>
    <input type="file" name="media" accept="image/*,video/*" >

    <button type="submit" class="submit-btn">Upload</button>
    <a href="feed.php" class="submit-btn">Cancel</a>

</form>

</body>
</html>
