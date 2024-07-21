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
<div class="bg-red-400 p-5 mt-5 shadow-lg  rounded-lg w-11/12 md:w-7/10 lg:w-4/5 mt-12 mb-16 break-words hover-grow transition-transform duration-300 ease-in-out rounded-lg">
    <h1 class="ml-5 mb-4 text-3xl font-bold" >Welcome, Mr. <?php echo htmlspecialchars($user_name); ?>!</h1>
    <p class="text-xl mb-3"> See Your Expenses below !</p>
</div>
<div class="bg-white p-5 mt-5 shadow-lg rounded-lg w-11/12 md:w-7/10 lg:w-4/5  mx-auto mb-13 break-words hover-grow transition-transform duration-300 ease-in-out rounded-lg">
    <div class="flex flex-col lg:flex-row lg:gap-2 justify-around  mb-5 text-center  ">
        <div  class="bg-red-500 p-5 rounded-lg w-full  mb-5 lg:mb-0 hover-grow transition-transform duration-300 ease-in-out rounded-lg">
            <h2 class="ml-5 mb-4 text-3xl font-bold">Daily Expenses</h2>
            <p class="text-xl mb-3">Total: <?php echo $daily_expenses; ?></p>
            <a href="view_daily_expenses.php" class="text-blue-800 no-underline mr-5 font-bold hover:underline">View Daily Expenses</a>
        </div>
        <div class="bg-yellow-600 p-5 rounded-lg w-full  mb-5 lg:mb-0  hover-grow transition-transform duration-300 ease-in-out rounded-lg">
            <h2 class="ml-5 mb-4 text-3xl font-bold">Weekly Expenses</h2>
            <p class="text-xl mb-3">Total: <?php echo $weekly_expenses; ?></p>
            <a href="view_weekly_expenses.php" class="text-blue-800 no-underline mr-5 font-bold hover:underline">View Weekly Expenses</a>
        </div>
        <div class="bg-gray-200 p-5 rounded-lg w-full   hover-grow transition-transform duration-300 ease-in-out rounded-lg">
            <h2 class="ml-5 mb-4 text-3xl font-bold">Monthly Expenses</h2>
            <p class="text-xl mb-3">Total: <?php echo $monthly_expenses; ?></p>
            <a href="view_monthly_expenses.php" class="text-blue-800 no-underline mr-5 font-bold hover:underline" >View Monthly Expenses</a>
        </div>
    </div>

    <div class="actions">
        <a href="add_expense.php" class=" no-underline text-blue-500 text-2xl p-2 bg-gray-200 rounded-lg text-center mb-4 hover:bg-red-300" >Add Expense</a>
        <a href="view_expenses.php" class=" no-underline text-blue-500 text-2xl p-2 bg-gray-200 rounded-lg text-center mb-4 hover:bg-red-300">See All Expenses</a>
        <a href="graphical_view.php" class=" no-underline text-blue-500 text-2xl  p-2 bg-gray-200 rounded-lg text-center mb-4 hover:bg-red-300">Graphical view</a>
    </div>
</div>
<?php
 include 'include/footer.php'; 
?>
</body>
</html>