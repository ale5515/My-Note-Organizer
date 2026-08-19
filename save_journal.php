<?php
session_start();
include 'db.php';

// Only allow saving if journal is Unlocked state is true
if (!isset($_SESSION['journal_unlocked']) || $_SESSION['journal_unlocked'] !== true) {
    die("Access Denied: Journal is locked.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    $sql = "INSERT INTO journal_entries (user_id, title, content) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iss", $user_id, $title, $content);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: dashboard.php?page=journal");
    }
}
?>