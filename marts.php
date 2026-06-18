<?php
include 'config.php';

$sql = "SELECT * FROM marts ORDER BY id DESC";
$stmt = $pdo->query($sql);
$marts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Business Partners</title>
 <link rel="stylesheet" href="style.css?v=3">
</head>
<body>

<h2>Business Partners (Marts)</h2>
<a class="btn" href="mart_add.php">+ Add New Mart</a>
<br><br>

<?php foreach ($marts as $row): ?>
<div class="mart-card">
    <?php if ($row['image']): ?>
        <img src="uploads/marts/<?= $row['image'] ?>" width="150" style="border-radius:8px;"><br><br>
    <?php endif; ?>

    <h3><?= $row['mart_name'] ?></h3>
    <p><strong>Address:</strong> <?= $row['address'] ?></p>
    <p><strong>Phone:</strong> <?= $row['phone'] ?></p>
    <p><strong>Website:</strong> <a href="<?= $row['website'] ?>" target="_blank"><?= $row['website'] ?></a></p>

    <a class="btn" href="mart_edit.php?id=<?= $row['id'] ?>">Edit</a>
    <a class="btn delete" href="mart_delete.php?id=<?= $row['id'] ?>">Delete</a>
</div>

<?php endforeach; ?>

</body>
</html>
