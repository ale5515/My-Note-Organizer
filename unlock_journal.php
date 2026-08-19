<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['journal_pass'])) {
    $input_password = $_POST['journal_pass'];
    $user_id = $_SESSION['user_id'];

    // 2. Fetch the hashed password specific user
    $sql = "SELECT password FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    // 3. Verify the input 
    if ($user && password_verify($input_password, $user['password'])) {
        $_SESSION['journal_unlocked'] = true;
        header("Location: dashboard.php?page=journal");
        exit();
} else {
    echo "Wrong password! <a href='dashboard.php'>Try again</a>";
}
if ($user && password_verify($input_password, $user['password'])) {
    $_SESSION['journal_unlocked'] = true;
    $_SESSION['journal_last_activity'] = time();
    header("Location: dashboard.php?page=journal");
    exit();
}
}
?>