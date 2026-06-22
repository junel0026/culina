<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: marts.php");
    exit;
}

$name = $_POST['mart_name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$website = $_POST['website'];

$imageName = null;

// Handle image upload
if (!empty($_FILES['image']['name'])) {

    // Create folder if missing
    if (!is_dir("../uploads/marts")) {
        mkdir("../uploads/marts", 0777, true);
    }

    $imageName = time() . "_" . basename($_FILES['image']['name']);
    $target = "../uploads/marts/" . $imageName;

    move_uploaded_file($_FILES['image']['tmp_name'], $target);
}

// Insert into DB
$sql = "INSERT INTO marts (mart_name, image, address, phone, website)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $pdo->prepare($sql);
$stmt->execute([$name, $imageName, $address, $phone, $website]);

header("Location: marts.php");
exit;
