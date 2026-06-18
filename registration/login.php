<!DOCTYPE html>
<html>
<head>
    <title>Log In</title>
    <link rel="stylesheet" href="registration.css">
</head>
<body class="auth-bg">

<div class="auth-box">
    <h2>Log In</h2>

    <form action="login_process.php" method="POST">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">LOG IN</button>
    </form>

    <p>Don’t have an account? <a href="signup.php">Sign Up!</a></p>
</div>

</body>
</html>
