<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Account</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="floating-video-card">
    <div class="video-header">
        <span><i class="fas fa-play-circle"></i> ~Hello there~ Yes, you!</span>
        <button onclick="this.parentElement.parentElement.style.display='none'">&times;</button>
    </div>
    <div class="video-body">
        <video autoplay muted loop playsinline>
            <source src="sign.mp4" type="video/mp4">
        </video>
    </div>
</div>
<div class="auth-container">
    <h1>Create Account</h1>
    <p id="loginwords">Join us and start organizing!</p>
    
    <form action="signup_handler.php" method="POST">
        <input type="text" name="full_name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign Up</button>
    </form>
    
    <div class="auth-footer">
        Already have an account? <a href="login.php">Login</a>
    </div>
</div>
</body>
</html>