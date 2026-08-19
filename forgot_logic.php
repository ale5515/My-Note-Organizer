<?php
// Debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Europe/Bucharest');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 
include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // DYNAMIC: Get the email from the user's input
    $user_email = mysqli_real_escape_string($conn, $_POST['email']);

    $result = mysqli_query($conn, "SELECT id FROM users WHERE email = '$user_email'");

    if (mysqli_num_rows($result) > 0) {
        $token = bin2hex(random_bytes(32));
        $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));
        
        mysqli_query($conn, "UPDATE users SET reset_token = '$token', token_expiry = '$expiry' WHERE email = '$user_email'");

        $reset_link = "http://localhost/organizer/reset_password.php?token=$token";

        $mail = new PHPMailer(true);
try {
   $mail->isSMTP();
$mail->Host       = 'smtp.mailersend.net';
$mail->SMTPAuth   = true;
$mail->Username   = 'MS_KvKQgB@test-68zxl273vxk4j905.mlsender.net'; 
$mail->Password   = 'mssp.rCXZuaQ.x2p03476v5pgzdrn.2EuKaj0'; 
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;
$mail->setFrom('MS_KvKQgB@test-68zxl273vxk4j905.mlsender.net', 'Organizer App');
    $mail->addAddress($user_email); 

    $mail->isHTML(true);
    $mail->Subject = 'Password Reset Request';
    $mail->Body    = "To reset your password, click here: <a href='$reset_link'>$reset_link</a>";

    $mail->send();
    header("Location: pages/forgot.php?sent=1");
    exit();
} catch (Exception $e) {
    die("System Mailer Error: " . $mail->ErrorInfo);
}
} else {
    die("No account found with that email.");
}
}