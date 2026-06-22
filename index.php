<?php
session_start();
require 'config.php';
$stmt = $pdo->query("
    SELECT foods.*, food_categories.name AS category_name
    FROM foods
    LEFT JOIN food_categories
        ON food_categories.id = foods.category_id
    WHERE foods.id IN (1, 2, 3, 4)
");
$foods = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Home | Recipes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1 class="page-title">Culina Mm</h1>
    <div class="menu_row_for">

        <h4><a href="recipe.php" class="menu_item">Recipes</a></h4>
        <h4><a href="marts.php" class="menu_item">Business Partners</a></h4>

        <?php if (!isset($_SESSION['user'])): ?>
            <!-- Show SignUp only when NOT logged in -->
            <h4><a href="registration/signup.php" class="menu_item">SignUP</a></h4>
        <?php endif; ?>

        <?php if (isset($_SESSION['user']) && $_SESSION['user']['is_admin'] == 1): ?>
            <!-- Admin sees Admin Panel instead of Hello -->
            <h4><a href="admin/admin_dashboard.php" class="menu_item">Admin Panel</a></h4>

        <?php else: ?>
            <!-- Normal users see Hello, Name -->
            <?php if (isset($_SESSION['user'])): ?>
                <h3>Hello, <?= $_SESSION['user']['name'] ?>!</h3>
                <a href="registration/logout.php" class="menu_item">Logout</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>


<div class="purpose">
    <h4 class ="food_title"> မြန်မာ့အစားအစာ </h4>
    <p class="letter"> မြန်မာနိုင်ငံ၏ အစားအသောက်များသည် သဘာဝပစ္စည်းများနှင့် ဒေသအလိုက် ရရှိနိုင်သော အစားအစာများအပေါ် အခြေခံထားပြီး ချဉ်၊ စပ်၊ ဆား၊ချို စတဲ့ အရသာလေးမျိုးကို <br>
    တစ်ပြိုင်တည်း ချိန်ညှိထားတာဖြစ်ပါတယ်။ ဆန်၊ ငါး၊ ပုဇွန်၊ အုန်းနို့၊ သကြားသီး၊ ပဲသီး စတဲ့ ပစ္စည်းများကို အခြေခံပြီး <br>
     မုန့်တီ၊ မုန့်ဟင်းခါး၊ လာဖက်သုပ်၊ မုန့်လက်ဆောင်း စတဲ့ အစားအစာများကို ပြုလုပ်ကြပါတယ်။ ဒေသအလိုက်လည်း အရသာကွာခြားပြီး <br>
      ရခိုင်ဒေသမှာ ချဉ်စပ်သွက်သွက်၊ မန္တလေးဒေသမှာ အနံ့အရသာပြည့်၊ ရှမ်းဒေသမှာ ပေါ့ပေါ့သက်သက်နဲ့ သဘာဝအရသာရှိပါတယ်။ <br>
      မြန်မာအစားအစာတွေဟာ သဘာဝအနံ့အရသာပြည့်ပြီး စားသူကို သက်သာစေတဲ့ အထူးသဘောသဘာဝရှိတဲ့ အစားအစာများဖြစ်ပါတယ်။
</div>

<h1 class="summer">နွေပူပူနဲ့လိုက်ဖက်သောအစားအစာများ (နွေစာများ)</h1>

<div class="recipe-grid">
    <?php foreach($foods as $f): ?>
        <div class="recipe-card">

            <div class="recipe-img">
                <img src="Home Page Photos/<?= $f['image'] ?>">
            </div>
            <p class="desc"><?= $f['description'] ?></p>
            <a href="recipe_detail.php?id=<?= $f['id'] ?>" class="view-btn">View Recipe</a>

            <div class="meta">
                <span><?= $f['calories'] ?> kcal</span>
                <span><?= $f['cook_time'] ?> min</span>
                <span class="category"><?= $f['category_name'] ?></span>
            </div>

        </div>
    <?php endforeach; ?>
</div>

<div class="footer">
    <h4> GOOD FLAVOR </h4>
    <h5> Spread the Website. </h5>
    <p> “Promote us on social media to share, learn, and grow together in our mission for eco‑friendly <br>
    and budget‑friendly recipes. Your voice matters, and we look forward to welcoming you into <br>
    our committed community!” <p>

</div>

</body>
</html>
