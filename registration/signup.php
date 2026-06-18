<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="registration.css">
</head>
<body class="auth-bg">

<div class="auth-box">

    <div class="signup-columns">

        <div class="signup-left">
            <h2>Create Account</h2>

            <form action="signup_process.php" method="POST">
                <input type="text" name="name" placeholder="Your name" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm" placeholder="Confirm Password" required>

                <button type="submit">Sign Up</button>
            </form>

            <p>Already have an account? <a href="login.php">Log in</a></p>
        </div>

        <div class="signup-right">
            <img src="signupbg.jpg" class="sign_up_bg">
        </div>

    </div>

</div>

</body>
</html>
