<?php
include_once './db.php';
$user_id = $_SESSION['user_id'];
// --- 1.ADDING SHOPPING ITEMS ---
if (isset($_POST['add_shopping'])) {
    $item = mysqli_real_escape_string($conn, $_POST['item_name']);
    $qty = (int)$_POST['qty'];
    $price = (float)$_POST['price'];
    
    $q = "INSERT INTO shopping_list (user_id, item_name, qty, price, created_at) 
          VALUES ($user_id, '$item', $qty, $price, NOW())";
    
    if(!mysqli_query($conn, $q)) { echo "Error: " . mysqli_error($conn); }
    header("Location: dashboard.php?page=shopping");
    exit();
}

// --- 2.ADDING OUT & FUN EXPENSES ---
if (isset($_POST['add_entertainment'])) {
    $place = mysqli_real_escape_string($conn, $_POST['place_name']);
    $amount = (float)$_POST['amount'];
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);
    
    $q = "INSERT INTO entertainment_expenses (user_id, place_name, amount, notes, created_at) 
          VALUES ($user_id, '$place', $amount, '$notes', NOW())";
    
    if(!mysqli_query($conn, $q)) { echo "Error: " . mysqli_error($conn); }
    header("Location: dashboard.php?page=shopping");
    exit();
}

// --- 3.DELETIONS ---
if (isset($_GET['del_shop'])) {
    $id = (int)$_GET['del_shop'];
    mysqli_query($conn, "DELETE FROM shopping_list WHERE id = $id AND user_id = $user_id");
    header("Location: dashboard.php?page=shopping");
}

if (isset($_GET['del_fun'])) {
    $id = (int)$_GET['del_fun'];
    mysqli_query($conn, "DELETE FROM entertainment_expenses WHERE id = $id AND user_id = $user_id");
    header("Location: dashboard.php?page=shopping");
}

// Current Time Variables
$currentMonth = date('m');
$currentYear = date('Y');

// --- 4. CALCULATIONS ---
$shop_res = mysqli_query($conn, "SELECT SUM(price * qty) as total FROM shopping_list WHERE user_id = $user_id AND MONTH(created_at) = $currentMonth");
$grocery_total = mysqli_fetch_assoc($shop_res)['total'] ?? 0;

$fun_res = mysqli_query($conn, "SELECT SUM(amount) as total FROM entertainment_expenses WHERE user_id = $user_id AND MONTH(created_at) = $currentMonth");
$fun_total = mysqli_fetch_assoc($fun_res)['total'] ?? 0;

$monthly_total = $grocery_total + $fun_total;
?>

<div class="shopping-layout" style="display: flex; flex-direction: column; gap: 20px;">
    
    <div class="card" style="min-height: auto;">
        <h4 style="color: #6c5ce7; margin-bottom: 5px;"><i class="fas fa-shopping-cart"></i> Shopping List</h4>
        <form method="POST" style="display: flex; gap: 10px; margin-top: 15px;">
            <input type="text" name="item_name" placeholder="Item name..." required style="flex: 4;">
            <input type="number" name="qty" value="1" style="flex: 0.8;">
            <input type="number" name="price" placeholder="Price" step="0.01" style="flex: 1;">
            <button type="submit" name="add_shopping" style="width: auto; background: #000; padding: 0 25px;">+ Add</button>
        </form>

        <div class="list-display" style="margin-top: 20px;">
            <?php
            $items = mysqli_query($conn, "SELECT * FROM shopping_list WHERE user_id = $user_id AND MONTH(created_at) = $currentMonth ORDER BY created_at DESC");
            while($row = mysqli_fetch_assoc($items)) {
                echo "<div style='display:flex; justify-content:space-between; padding: 10px; border-bottom:1px solid #eee;'>";
                echo "<span>" . htmlspecialchars($row['item_name']) . " (x" . $row['qty'] . ")</span>";
                echo "<span>" . number_format($row['price'] * $row['qty'], 2) . " lei <a href='dashboard.php?page=shopping&del_shop=".$row['id']."' style='color:red; margin-left:10px;'>&times;</a></span>";
                echo "</div>";
            }
            ?>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
        <div class="card" style="min-height: auto; text-align:center;">
            <small>GROCERY</small>
            <h2 style="color: #6c5ce7;"><?php echo number_format($grocery_total, 2); ?> lei</h2>
        </div>
        <div class="card" style="min-height: auto; text-align:center;">
            <small>OUT & FUN</small>
            <h2 style="color: #a29bfe;"><?php echo number_format($fun_total, 2); ?> lei</h2>
        </div>
        <div class="card" style="min-height: auto; text-align:center;">
            <small><?php echo date('F Y'); ?></small>
            <h2 style="color: #00b894;"><?php echo number_format($monthly_total, 2); ?> lei</h2>
        </div>
    </div>

    <div class="card" style="min-height: auto;">
        <h4 style="color: #a29bfe;"><i class="fas fa-glass-cheers"></i> Out & Fun</h4>
        <form method="POST" style="display: flex; gap: 10px; margin-top: 15px;">
            <input type="text" name="place_name" placeholder="Place..." required style="flex: 2;">
            <input type="number" name="amount" placeholder="Amount" step="0.01" style="flex: 1;">
            <input type="text" name="notes" placeholder="Notes" style="flex: 2;">
            <button type="submit" name="add_entertainment" style="width: auto; background: #6c5ce7; padding: 0 25px;">+ Add</button>
        </form>

        <div class="list-display" style="margin-top: 20px;">
            <?php
            $funs = mysqli_query($conn, "SELECT * FROM entertainment_expenses WHERE user_id = $user_id AND MONTH(created_at) = $currentMonth ORDER BY created_at DESC");
            while($row = mysqli_fetch_assoc($funs)) {
                echo "<div style='display:flex; justify-content:space-between; padding: 10px; border-bottom:1px solid #eee;'>";
                echo "<span>" . htmlspecialchars($row['place_name']) . "</span>";
                echo "<span>" . number_format($row['amount'], 2) . " lei <a href='dashboard.php?page=shopping&del_fun=".$row['id']."' style='color:red; margin-left:10px;'>&times;</a></span>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</div>
<div class="floating-video-card">
    <div class="video-header">
        <span><i class="fas fa-play-circle"></i> Planning time!</span>
        <button onclick="this.parentElement.parentElement.style.display='none'">&times;</button>
    </div>
    <div class="video-body">
        <video autoplay muted loop playsinline>
            <source src="./grocery1.mp4" type="video/mp4">
        </video>
    </div>
</div>