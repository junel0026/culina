<?php
session_start();
require "../config.php";   // correct if file is inside /registration/

$email = trim($_POST['email']);
$pass = $_POST['password'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user || !password_verify($pass, $user['password'])) {
    die("Invalid email or password");
}

// ⭐ Save ONLY the fields you need
$_SESSION['user'] = [
    'id' => $user['id'],
    'name' => $user['name'],
    'email' => $user['email'],
    'avatar' => $user['avatar'],   // ⭐ IMPORTANT
    'is_admin' => $user['is_admin']
];

// ⭐ Redirect to feed or dashboard
header("Location: /culina/index.php");
exit;
