<?php
include_once './db.php';
$user_id = $_SESSION['user_id'];
$today = date('Y-m-d');
if (isset($_POST['add_goal'])) {
    $goal = mysqli_real_escape_string($conn, $_POST['goal_text']);
    mysqli_query($conn, "INSERT INTO daily_goals (user_id, goal_text, is_completed, created_at) VALUES ($user_id, '$goal', 0, '$today')");
    echo "<script>window.location='dashboard.php?page=goals';</script>";
    exit();
}
if (isset($_GET['complete_id'])) {
    $id = (int)$_GET['complete_id'];
    mysqli_query($conn, "UPDATE daily_goals SET is_completed = 1 WHERE id = $id AND user_id = $user_id");
    echo "<script>window.location='dashboard.php?page=goals';</script>";
    exit();
}
?>

<div class="goals-layout">
    <div style="background: #f0faff; border: 1px solid #cdefff; padding: 20px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; gap: 15px;">
        <i class="fas fa-lightbulb" style="color: #3498db;"></i>
        <p style="margin: 0; font-style: italic; color: #2c3e50; font-size: 14px;">"Small steps every day lead to big results."</p>
    </div>

    <div class="card" style="padding: 30px; border-radius: 15px;">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 25px;">
            <i class="fas fa-bullseye" style="color: #6c5ce7;"></i>
            <h4 style="margin: 0;">Daily Goals</h4>
        </div>

        <form method="POST" style="display: flex; gap: 0; margin-bottom: 30px;">
            <input type="text" name="goal_text" placeholder="What do you want to achieve today?" required 
                   style="border-radius: 10px 0 0 10px; border: 1px solid #ddd; padding: 12px 15px; flex: 1;">
            <button type="submit" name="add_goal" 
                    style="width: auto; background: #000; color: #fff; padding: 0 25px; border-radius: 0 10px 10px 0; border: 1px solid #000; cursor: pointer;">
                + Add
            </button>
        </form>

        <div class="goals-list">
            <?php
            $res = mysqli_query($conn, "SELECT * FROM daily_goals WHERE user_id = $user_id AND is_completed = 0 AND created_at = '$today' ORDER BY id DESC");
            
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    ?>
                    <div id="goal-container-<?php echo $row['id']; ?>" class="goal-item" 
                         style="display: flex; align-items: center; padding: 15px 0; border-bottom: 1px solid #f1f2f6;">
                        
                        <a href="javascript:void(0);" onclick="animateCompletion(<?php echo $row['id']; ?>)" 
                           id="icon-<?php echo $row['id']; ?>"
                           style="font-size: 22px; color: #dfe6e9; margin-right: 15px; transition: 0.3s; text-decoration: none;">
                            <i class="far fa-circle"></i>
                        </a>

                        <span id="text-<?php echo $row['id']; ?>" class="goal-text" style="font-size: 16px; color: #2d3436;">
                            <?php echo htmlspecialchars($row['goal_text']); ?>
                        </span>
                    </div>
                    <?php
                }
            } else {
                echo "<div style='text-align: center; padding: 40px; color: #b2bec3;'>
                        <p>No goals set yet for today! 🎯</p>
                      </div>";
            }
            ?>
        </div>
    </div>
</div>

<div class="floating-video-card">
    <div class="video-header">
        <span><i class="fas fa-play-circle"></i> Focus Buddy</span>
        <button onclick="this.parentElement.parentElement.style.display='none'">&times;</button>
    </div>
    <div class="video-body">
        <video autoplay muted loop playsinline>
            <source src="cute1.mp4" type="video/mp4">
        </video>
    </div>
</div>

<script>
function animateCompletion(id) {
    const container = document.getElementById('goal-container-' + id);
    const text = document.getElementById('text-' + id);
    const icon = document.getElementById('icon-' + id);
    icon.innerHTML = '<i class="fas fa-check-circle"></i>';
    icon.style.color = '#00b894';

    text.classList.add('is-striking');
    container.classList.add('goal-disappear');
    setTimeout(() => {
        window.location.href = 'dashboard.php?page=goals&complete_id=' + id;
    }, 1300);
}
</script>