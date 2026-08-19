<?php
include 'db.php'; 
date_default_timezone_set('Europe/Bucharest');
/** @var mysqli $conn */

$token = $_GET['token'] ?? '';

// Check token existance
$query = "SELECT id FROM users WHERE reset_token = '$token' AND token_expiry > NOW()";
$res = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($res);

if (!$user) { 
    die("<body style='text-align:center; padding-top:50px;'><h2>Invalid or Expired Link</h2><a href='pages/forgot.php'>Request a new one</a></body>"); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user_id = $user['id'];

    $update = "UPDATE users SET password='$new_pass', reset_token=NULL, token_expiry=NULL WHERE id=$user_id";
    if (mysqli_query($conn, $update)) {
        header("Location: login.php?msg=success");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>New Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-body">
    <div class="auth-card">
        <h2>Set New Password</h2>
        <form method="POST">
            <input type="password" name="password" placeholder="New Password" required minlength="6">
            <button type="submit" class="btn-auth">Update Password</button>
        </form>
    </div>
</body>
</html>