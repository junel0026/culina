<?php
require "../config.php";

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$pass = $_POST['password'];
$confirm = $_POST['confirm'];

if ($pass !== $confirm) {
    die("Passwords do not match");
}

$hashed = password_hash($pass, PASSWORD_DEFAULT);

// Insert user
$stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->execute([$name, $email, $hashed]);

header("Location: login.php");
exit;
