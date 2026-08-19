<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="auth-body">
    <div class="auth-card">
        <h2>Reset Password</h2>
        
        <?php if(isset($_GET['sent'])): ?>
            <p style="color: #2ecc71; font-weight: bold; margin-bottom: 15px;">✅ Reset link sent to your email!</p>
        <?php elseif(isset($_GET['error'])): ?>
            <p style="color: #e74c3c; margin-bottom: 15px;">Email address not found.</p>
        <?php endif; ?>

        <form action="../forgot_logic.php" method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit" class="btn-auth">Send Reset Link</button>
        </form>

        <div class="auth-footer">
            <a href="../login.php">Back to Login</a>
        </div>
    </div>
    <div class="floating-video-card">
    <div class="video-header">
        <span><i class="fas fa-play-circle"></i> Focus Buddy</span>
        <button onclick="this.parentElement.parentElement.style.display='none'">&times;</button>
    </div>
    <div class="video-body">
        <video autoplay muted loop playsinline>
            <source src="../forgot.mp4" type="video/mp4">
        </video>
    </div>
</div>
</body>
</html>