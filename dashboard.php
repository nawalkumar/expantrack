<?php
include 'include/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT name FROM users WHERE id='$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_name = $user['name'];
} else {
    
    header('Location: login.php');
    exit();
}
$total_expenses = 0;
$sql = "SELECT SUM(amount) AS total FROM expenses WHERE user_id='$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $total = $result->fetch_assoc();
    $total_expenses = $total['total'];
}

// Fetch expenses by category
$daily_expenses = $weekly_expenses = $monthly_expenses = 0;

// Daily
$sql = "SELECT SUM(amount) AS total FROM expenses WHERE user_id='$user_id' AND date >= CURDATE()";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $daily = $result->fetch_assoc();
    $daily_expenses = $daily['total'];
}

// Weekly
$sql = "SELECT SUM(amount) AS total FROM expenses WHERE user_id='$user_id' AND date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
$result = $conn->query($sql);
if ($result->num_rows > 0) 
{
    $weekly = $result->fetch_assoc();
    $weekly_expenses = $weekly['total'];
}

// Monthly
$sql = "SELECT SUM(amount) AS total FROM expenses WHERE user_id='$user_id' AND date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $monthly = $result->fetch_assoc();
    $monthly_expenses = $monthly['total'];
}
?>
<div class="container">
   
    <h1>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
    <p>Your Expenses !</p>

    <div class="dashboard-container">
        <div class="dashboard-item1">
            <h2>Daily Expenses</h2>
            <p>Total: <?php echo $daily_expenses; ?></p>
            <a href="view_daily_expenses.php">View Daily Expenses</a>
        </div>
        <div class="dashboard-item2">
            <h2>Weekly Expenses</h2>
            <p>Total: <?php echo $weekly_expenses; ?></p>
            <a href="view_weekly_expenses.php">View Weekly Expenses</a>
        </div>
        <div class="dashboard-item3">
            <h2>Monthly Expenses</h2>
            <p>Total: <?php echo $monthly_expenses; ?></p>
            <a href="view_monthly_expenses.php">View Monthly Expenses</a>
        </div>
    </div>

    <div class="actions">
        <a href="add_expense.php">Add Expense</a>
        <a href="view_expenses.php">See All Expenses</a>
        <a href="graphical_view.php">Graphical view</a>
    </div>
</div>
<?php
 include 'include/footer.php'; 
?>
</body>
</html>