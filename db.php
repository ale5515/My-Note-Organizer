<?php
$host = "localhost";
$user = "root";     
$pass = "";         
$dbname = "organizer_db"; 

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Local Connection failed: " . mysqli_connect_error());
}
?>