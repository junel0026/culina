<?php
include 'config.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM marts WHERE id = :id");
$stmt->execute([':id' => $id]);
$mart = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $imageName = $mart['image']; // keep old image

    // If new image uploaded
    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . $_FILES['image']['name'];
        $target = "uploads/marts/" . $imageName;

        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    $sql = "UPDATE marts SET
            mart_name = :name,
            image = :image,
            address = :address,
            phone = :phone,
            website = :website
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $_POST['mart_name'],
        ':image' => $imageName,
        ':address' => $_POST['address'],
        ':phone' => $_POST['phone'],
        ':website' => $_POST['website'],
        ':id' => $id
    ]);

    header("Location: marts.php");
}
?>

<!DOCTYPE html>
<html>
<head><title>Edit Mart</title>
<link rel="stylesheet" href="style.css?v=3">
</head>
<body>

<h2>Edit Business Partner</h2>

<form method="POST" enctype="multipart/form-data">

    <label>Mart Name</label><br>
    <input type="text" name="mart_name" value="<?= $mart['mart_name'] ?>" required><br><br>

    <label>Current Image</label><br>
    <?php if ($mart['image']): ?>
        <img src="uploads/marts/<?= $mart['image'] ?>" width="120"><br><br>
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
