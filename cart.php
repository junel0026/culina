<?php
session_start();

require "config.php";

$cart = $_SESSION['cart'] ?? [];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link rel="stylesheet" href="cart.css?v=3">
</head>
<body>

<h1 class="page-title">🛒 Your Cart</h1>

<div class="cart-container">

<?php if (empty($cart)): ?>

    <p class="empty-cart">Your cart is empty.</p>

<?php else: ?>

    <?php foreach ($cart as $id => $qty):
        $stmt = $pdo->prepare("SELECT name, image FROM new_ingredients WHERE id = ?");
        $stmt->execute([$id]);
        $ing = $stmt->fetch();
    ?>

    <div class="cart-item">

        <img src="Home Page Photos/<?= $ing['image'] ?>" class="cart-img">

        <div class="cart-info">
            <h3><?= $ing['name'] ?></h3>
            <p>Quantity: <?= $qty ?></p>
        </div>

        <form action="remove_from_cart.php" method="POST">
            <input type="hidden" name="id" value="<?= $id ?>">
            <button class="remove-btn">Remove</button>
        </form>

    </div>

    <?php endforeach; ?>

<?php endif; ?>

</div>

</body>
</html>
