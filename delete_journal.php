<?php
session_start();
include_once 'db.php';

// 1. Security Check
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 2. Get the ID and Delete
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Delete 'journal_entries' table
    $query = "DELETE FROM journal_entries WHERE id = $id AND user_id = $user_id";
    
    if(mysqli_query($conn, $query)) {
        // Success:data is gone from the database
    }
}

// 3. The "Stay in Journal" 
header("Location: dashboard.php?page=journal");
exit();
?>