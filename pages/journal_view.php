<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include_once './db.php';

if (!isset($_SESSION['user_id'])) {
    echo "Access Denied.";
    exit;
}

$user_id = (int)$_SESSION['user_id'];

// --- LOCKED ---
if (!isset($_SESSION['journal_unlocked'])) { 
?> <div class="floating-video-card">
    <div class="video-header">
        <span><i class="fas fa-play-circle"></i> What you are thinking about?</span>
        <button onclick="this.parentElement.parentElement.style.display='none'">&times;</button>
    </div>
    <div class="video-body">
        <video autoplay muted loop playsinline>
            <source src="journal.mp4" type="video/mp4">
        </video>
    </div>
</div>
    <div class="card" style="text-align: center; padding: 40px; max-width: 500px; margin: 40px auto; border-top: 5px solid #e67e22;">
        <i class="fas fa-user-secret" style="font-size: 50px; color: #e67e22; margin-bottom: 20px;"></i>
        <h3>My Secret Journal</h3>
        <form action="unlock_journal.php" method="POST">
            <input type="password" name="journal_pass" placeholder="Password" required 
                   style="width: 100%; padding: 12px; margin: 20px 0; border-radius: 8px; border: 1px solid #ddd;">
            <button type="submit" class="btn-save" style="background: #e67e22; width: 100%;">Unlock</button>
        </form>
    </div>
<?php 
} else { 
// --- UNLOCKED ---
?> <div class="floating-video-card">
    <div class="video-header">
        <span><i class="fas fa-play-circle"></i> My Duduuuuu</span>
        <button onclick="this.parentElement.parentElement.style.display='none'">&times;</button>
    </div>
    <div class="video-body">
        <video autoplay muted loop playsinline>
            <source src="journalunlocked.mp4" type="video/mp4">
        </video>
    </div>
</div>
    <div class="journal-container">
        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <h2 style="color: #d35400;"><i class="fas fa-book"></i> My Journal</h2>
            <a href="lock_journal.php" class="btn-lock" style="background: #e67e22; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none;">Lock</a>
        </div>

        <div class="paper-card" style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <form action="save_journal.php" method="POST">
                <input type="text" name="title" placeholder="Entry Title..." class="paper-title" required style="width:100%; border:none; border-bottom:1px solid #eee; padding:10px; margin-bottom:10px; outline:none;">
                <textarea name="content" placeholder="Dear Journal..." class="paper-body" required style="width:100%; border:none; min-height:150px; padding:10px; outline:none; resize:none;"></textarea>
                <button type="submit" class="btn-save">+ Save Entry</button>
            </form>
        </div>

        <div class="previous-entries" style="margin-top: 30px;">
            <?php
            $res = mysqli_query($conn, "SELECT * FROM journal_entries WHERE user_id = $user_id ORDER BY created_at DESC");
            while($row = mysqli_fetch_assoc($res)) {
                ?>
                <div class="entry-card" style="position: relative; background: white; margin-bottom: 15px; padding: 20px; border-left: 5px solid orange; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                    <a href="delete_journal.php?id=<?php echo $row['id']; ?>" 
                       style="position: absolute; top: 15px; right: 15px; color: #e74c3c;" 
                       onclick="return confirm('Delete this entry?')">
                        <i class="fas fa-trash"></i>
                    </a>
                    <h4 style="margin:0;"><?php echo htmlspecialchars($row['title']); ?></h4>
                    <small style="color:gray;"><?php echo $row['created_at']; ?></small>
                    
                    <p style="margin-top:10px; color:#555; line-height: 1.6;">
                        <?php 
                            // 1. htmlspecialchars for safety
                            // 2. stripslashes to remove the literal \r\n characters
                            // 3. nl2br to make real line breaks
                            $clean_content = stripslashes($row['content']);
                            echo nl2br(htmlspecialchars($clean_content)); 
                        ?>
                    </p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
<?php } ?>