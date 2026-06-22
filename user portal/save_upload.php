<?php
session_start();
require "../config.php";


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request");
}

$title = trim($_POST['title'] ?? '');
$desc  = trim($_POST['description'] ?? '');
$file  = $_FILES['media'] ?? null;

if ($title === '' || !$file || $file['error'] !== UPLOAD_ERR_OK) {
    die("Missing title or file");
}

$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$videoExt = ['mp4','mov','webm','mkv'];
$imageExt = ['jpg','jpeg','png','gif','webp'];

if (in_array($ext, $videoExt)) {
    $mediaType = 'video';
} elseif (in_array($ext, $imageExt)) {
    $mediaType = 'image';
} else {
    die("Unsupported file type");
}

$filename = uniqid('media_') . '.' . $ext;
$target   = __DIR__ . "/../Home Page Photos/" . $filename;

if (!move_uploaded_file($file['tmp_name'], $target)) {
    die("Upload failed");
}

$stmt = $pdo->prepare("
    INSERT INTO posts (user_id, title, description, media_type, media_path)
    VALUES (?, ?, ?, ?, ?)
");
$stmt->execute([$_SESSION['user']['id'], $title, $desc, $mediaType, $filename]);

header("Location: feed.php");
exit;
