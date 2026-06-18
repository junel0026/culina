<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Login required");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Avatar</title>
</head>
<body>

<h2>Create Your Avatar</h2>

<form action="save_avatar.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="avatar" accept="image/*" required>
    <button type="submit">Upload Avatar</button>
</form>

</body>
</html>
