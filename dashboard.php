<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
/*journal safety measure: if the journal is unlocked, check how long it's been since the last activity. If it's been more than 20 seconds, lock it again. This way, if someone walks away from their computer, the journal will automatically lock after 20 seconds of inactivity.*/
$timeout_duration = 20;

if (isset($_SESSION['journal_unlocked']) && $_SESSION['journal_unlocked'] === true) {
    
    if (!isset($_SESSION['journal_last_activity'])) {
        $_SESSION['journal_last_activity'] = time();
    }

    $elapsed_time = time() - $_SESSION['journal_last_activity'];

    if ($elapsed_time > $timeout_duration) {
        unset($_SESSION['journal_unlocked']);
        unset($_SESSION['journal_last_activity']);
    } else {
        $_SESSION['journal_last_activity'] = time();
    }
}
// Quote Logic
$quotes = [
    ["text" => "I have a 'spending money' personality and a 'no money' reality.", "author" => "The Budget Struggle"],
    ["text" => "I put the 'pro' in procrastination. And by 'pro' I mean 'please help me.'", "author" => "Deadline Panic"],
    ["text" => "Brain: I can do this. Body: I need a nap. Coffee: Hold my beans.", "author" => "The Student Life"],
    ["text" => "Don't stop until you're proud.", "author" => "Future You"]
];
$randomQuote = $quotes[array_rand($quotes)];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - My Organizer</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="dashboard-body">

    <div class="app-container">
        <nav class="sidebar">
            <div class="profile-section">
                <div class="avatar-wrapper">
                    <?php 
                    $image_path = "uploads/profile_pics/user_default.png";
                    if (file_exists($image_path)) {
                        echo '<img src="'.$image_path.'" alt="Profile" class="profile-photo">';
                    } else {
                        $initial = strtoupper(substr($_SESSION['user_name'], 0, 1));
                        echo '<div class="profile-placeholder">'.$initial.'</div>';
                    }
                    ?>
                </div>
                <h3 class="user-name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></h3> 
            </div>
            
            <ul class="nav-links">
                <li><a href="dashboard.php?page=goals"><i class="fas fa-calendar-alt"></i> Daily Goals</a></li>
                <li><a href="dashboard.php?page=todo"><i class="fas fa-list-check"></i> To-Do List</a></li>
                <li><a href="dashboard.php?page=journal"><i class="fas fa-book"></i> My Journal</a></li>
                <li><a href="dashboard.php?page=currency"><i class="fas fa-coins"></i> Currency</a></li>
                <li><a href="dashboard.php?page=shopping"><i class="fas fa-cart-shopping"></i> Shopping List</a></li>
                <li class="logout-link">
                    <a href="logout.php"><i class="fas fa-right-from-bracket"></i> Logout</a>
                </li>
            </ul>
        </nav>

        <main class="main-content">
            
            <div class="motivation-banner">
                <div class="motivation-header">
                    <i class="fas fa-heart"></i>
                    <small>MOTIVATION</small>
                </div>
                <p class="quote-text">"<?php echo $randomQuote['text']; ?>"</p>
                <span class="quote-author">— <?php echo $randomQuote['author']; ?></span>
            </div>

            <div class="subpage-container">
                <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 'shopping';
                
                // Securely allow only specific page files
                $allowed_pages = ['shopping', 'todo', 'goals', 'journal', 'currency'];
                if (in_array($page, $allowed_pages)) {
                    include "pages/{$page}_view.php";
                } else {
                    include "pages/shopping_view.php";
                }
                ?>
            </div>
        </main>
    </div>
</body>
</html>