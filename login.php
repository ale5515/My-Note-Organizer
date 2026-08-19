<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">

<div class="login-card">
    <h1>Welcome Back!</h1>
    <p id="loginwords">Login to your account</p>
    
    <form action="login_handler.php" method="POST">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    
    <div class="footer-links">
        <a href="pages/forgot.php">Forgot Password?</a><br>
        Don't have an account? <a href="signup.php">Sign Up</a>
    </div>
</div>
<div class="floating-video-card">
    <div class="video-header">
        <span><i class="fas fa-play-circle"></i> Back to us!</span>
        <button onclick="this.parentElement.parentElement.style.display='none'">&times;</button>
    </div>
    <div class="video-body">
        <video autoplay muted loop playsinline>
            <source src="welcome.mp4" type="video/mp4">
        </video>
    </div>
</div>

</body>
</html>