<?php
include 'config.php';

$sql = "SELECT * FROM marts ORDER BY id DESC";
$stmt = $pdo->query($sql);
$marts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Our Partner Marts</title>
    <link rel="stylesheet" href="style.css?v=3">
</head>

<body>

<h2 class="mart-title">Our Partner Marts</h2>

<div class="mart-container">

<?php foreach ($marts as $row): ?>

<div class="mart-card">

    <div class="mart-row">

        <div class="mart-left">
            <?php if ($row['image']): ?>
                <img src="uploads/marts/<?= $row['image'] ?>" alt="<?= $row['mart_name'] ?>" class="mart-img">
            <?php endif; ?>
        </div>

        <div class="mart-right">
            <h3 class="mart-name"><?= $row['mart_name'] ?></h3>

            <div class="mart-info">
                <p><strong>Address:</strong> <?= $row['address'] ?></p>
                <p><strong>Phone:</strong> <?= $row['phone'] ?></p>
                <p><strong>Website:</strong>
                    <a href="<?= $row['website'] ?>" target="_blank">
                        <?= $row['website'] ?>
                    </a>
                </p>
            </div>
        </div>

    </div>

</div>


<?php endforeach; ?>

</div>

</body>
</html>
