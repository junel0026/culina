<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Handle image upload
    $imageName = null;

    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . $_FILES['image']['name'];
        $target = "../uploads/marts/" . $imageName;

        // Create folder if not exists
        if (!is_dir("../uploads/marts")) {
            mkdir("../uploads/marts", 0777, true);
        }

        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    $sql = "INSERT INTO marts (mart_name, image, address, phone, website)
            VALUES (:name, :image, :address, :phone, :website)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $_POST['mart_name'],
        ':image' => $imageName,
        ':address' => $_POST['address'],
        ':phone' => $_POST['phone'],
        ':website' => $_POST['website']
    ]);

    header("Location: admin_marts.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Mart</title>
    <link rel="stylesheet" href="marts.css?v=3">
</head>
<body>

<h2>Add Business Partner</h2>

<form action="" method="POST" enctype="multipart/form-data">

    <label>Mart Name</label>
    <input type="text" name="mart_name" required>

    <label>Image</label>
    <input type="file" name="image" accept="image/*">

    <label>Address</label>
    <input type="text" name="address">

    <label>Phone</label>
    <input type="text" name="phone">

    <label>Website</label>
    <input type="text" name="website">

    <button type="submit">Save</button>
</form>

</body>
</html>
