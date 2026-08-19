<?php
include_once './db.php';
$user_id = $_SESSION['user_id'];

// --- 1.ADDING TASKS ---
if (isset($_POST['add_task'])) {
    $task = mysqli_real_escape_string($conn, $_POST['task_text']);
    mysqli_query($conn, "INSERT INTO todo_list (user_id, task_text) VALUES ($user_id, '$task')");
    header("Location: dashboard.php?page=todo");
    exit();
}

// --- 2.TOGGLING COMPLETION ---
if (isset($_GET['toggle_id'])) {
    $tid = (int)$_GET['toggle_id'];
    mysqli_query($conn, "UPDATE todo_list SET is_completed = NOT is_completed WHERE id = $tid AND user_id = $user_id");
    header("Location: dashboard.php?page=todo");
    exit();
}

// --- 3.DELETING ---
if (isset($_GET['del_task'])) {
    $id = (int)$_GET['del_task'];
    mysqli_query($conn, "DELETE FROM todo_list WHERE id = $id AND user_id = $user_id");
    header("Location: dashboard.php?page=todo");
    exit();
}
?>

<div class="card">
    <div class="page-header" style="margin-bottom: 30px;">
        <h2 style="color: #2d3436;"><i class="fas fa-list-check" style="color: #0984e3;"></i> Master To-Do List</h2>
        <p>Organize your academic and personal tasks in one place.</p>
    </div>

    <form method="POST" style="display: flex; gap: 10px; margin-bottom: 30px;">
        <input type="text" name="task_text" placeholder="What needs to be done?" required style="flex: 1;">
        <button type="submit" name="add_task" style="width: auto; background: #2d3436; padding: 0 30px;">Add Task</button>
    </form>

    <div class="todo-container">
        <?php
        $res = mysqli_query($conn, "SELECT * FROM todo_list WHERE user_id = $user_id ORDER BY is_completed ASC, created_at DESC");
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $is_done = $row['is_completed'];
                ?>
                <div style="display: flex; align-items: center; padding: 15px; border-bottom: 1px solid #eee; background: <?php echo $is_done ? '#f9f9f9' : '#fff'; ?>;">
                    <a href="dashboard.php?page=todo&toggle_id=<?php echo $row['id']; ?>" style="font-size: 22px; margin-right: 15px; color: <?php echo $is_done ? '#00b894' : '#dfe6e9'; ?>;">
                        <i class="fa-<?php echo $is_done ? 'solid fa-circle-check' : 'regular fa-circle'; ?>"></i>
                    </a>

                    <span style="flex: 1; font-size: 18px; color: <?php echo $is_done ? '#b2bec3' : '#2d3436'; ?>; text-decoration: <?php echo $is_done ? 'line-through' : 'none'; ?>;">
                        <?php echo htmlspecialchars($row['task_text']); ?>
                    </span>

                    <a href="dashboard.php?page=todo&del_task=<?php echo $row['id']; ?>" style="color: #ff7675; margin-left: 15px;" onclick="return confirm('Delete this task?')">
                        <i class="fas fa-trash-can"></i>
                    </a>
                </div>
                <?php
            }
        } else {
            echo "<div style='text-align: center; padding: 50px; color: #b2bec3;'>No tasks yet. Stay productive!</div>";
        }
        ?>
    </div>
</div>
<div class="floating-video-card">
    <div class="video-header">
        <span><i class="fas fa-play-circle"></i> You got this!</span>
        <button onclick="this.parentElement.parentElement.style.display='none'">&times;</button>
    </div>
    <div class="video-body">
        <video autoplay muted loop playsinline>
            <source src="todo.mp4" type="video/mp4">
        </video>
    </div>
</div>