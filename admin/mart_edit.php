<?php
include '../config.php';

// Get ID from GET (first load) or POST (after submit)
$id = $_POST['id'] ?? $_GET['id'];

if (!$id) {
    die("Invalid ID");
}

// Fetch mart data
$stmt = $pdo->prepare("SELECT * FROM marts WHERE id = :id");
$stmt->execute([':id' => $id]);
$mart = $stmt->fetch();

if (!$mart) {
    die("Mart not found");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Mart</title>
    <link rel="stylesheet" href="marts.css?v=3">
</head>
<body>

<h2>Edit Business Partner</h2>

<form action="save_marts.php" method="POST" enctype="multipart/form-data">

    <!-- Hidden ID -->
    <input type="hidden" name="id" value="<?= $mart['id'] ?>">

    <label>Mart Name</label><br>
    <input type="text" name="mart_name" value="<?= $mart['mart_name'] ?>" required><br><br>

    <label>Current Image</label><br>
    <?php if ($mart['image']): ?>
        <img src="../uploads/marts/<?= $mart['image'] ?>" width="120"><br><br>
    <?php endif; ?>

    <label>Upload New Image</label><br>
    <input type="file" name="image" accept="image/*"><br><br>

    <label>Address</label><br>
    <input type="text" name="address" value="<?= $mart['address'] ?>"><br><br>

    <label>Phone</label><br>
    <input type="text" name="phone" value="<?= $mart['phone'] ?>"><br><br>

    <label>Website</label><br>
    <input type="text" name="website" value="<?= $mart['website'] ?>"><br><br>

    <button type="submit">Update</button>
</form>

</body>
</html>
