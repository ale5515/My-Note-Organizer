<?php
session_start();
unset($_SESSION['journal_unlocked']); 
header("Location: dashboard.php?page=journal");
?>