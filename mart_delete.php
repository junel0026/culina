<?php
include 'config.php';

$id = $_GET['id'];

// Get image name
$stmt = $pdo->prepare("SELECT image FROM marts WHERE id = :id");
$stmt->execute([':id' => $id]);
$mart = $stmt->fetch();

// Delete image file
if ($mart['image'] && file_exists("uploads/marts/" . $mart['image'])) {
    unlink("uploads/marts/" . $mart['image']);
}

// Delete DB row
$stmt = $pdo->prepare("DELETE FROM marts WHERE id = :id");
$stmt->execute([':id' => $id]);

header("Location: marts.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Mart</title>
</head>
<body>

<h2>Edit Business Partner</h2>

<form method="POST">
    <label>Mart Name</label><br>
    <input type="text" name="mart_name" value="<?= $mart['mart_name'] ?>" required><br><br>

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
