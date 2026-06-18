<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Handle image upload
    $imageName = null;

    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . $_FILES['image']['name'];
        $target = "uploads/marts/" . $imageName;

        // Create folder if not exists
        if (!is_dir("uploads/marts")) {
            mkdir("uploads/marts", 0777, true);
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

    header("Location: marts.php");
}
?>

<!DOCTYPE html>
<html>
<head><title>Add Mart</title></head>
<body>

<h2>Add Business Partner</h2>

<form method="POST" enctype="multipart/form-data">
    <label>Mart Name</label><br>
    <input type="text" name="mart_name" required><br><br>

    <label>Image</label><br>
    <input type="file" name="image" accept="image/*"><br><br>

    <label>Address</label><br>
    <input type="text" name="address"><br><br>

    <label>Phone</label><br>
    <input type="text" name="phone"><br><br>

    <label>Website</label><br>
    <input type="text" name="website"><br><br>

    <button type="submit">Save</button>
</form>

</body>
</html>
