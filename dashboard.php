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

$daily_expenses = $weekly_expenses = $monthly_expenses = 0;

$sql = "SELECT SUM(amount) AS total FROM expenses WHERE user_id='$user_id' AND date >= CURDATE()";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $daily = $result->fetch_assoc();
    $daily_expenses = $daily['total'];
}

$sql = "SELECT SUM(amount) AS total FROM expenses WHERE user_id='$user_id' AND date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $weekly = $result->fetch_assoc();
    $weekly_expenses = $weekly['total'];
}

$sql = "SELECT SUM(amount) AS total FROM expenses WHERE user_id='$user_id' AND date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $monthly = $result->fetch_assoc();
    $monthly_expenses = $monthly['total'];
}
?>
<div class="flex justify-center items-center w-11/12 md:w-7/10 lg:w-full mb-1 break-words rounded-lg bg-cover bg-center" style="background-image: url('include/assets/hero.jpg'); height: 70vh;">
    <div class="mx-auto p-6 rounded-lg shadow-lg bg-gray-200 bg-opacity-75 h-auto flex flex-col justify-center items-center">
        <h1 class="text-4xl font-bold mb-4 text-black text-center">Welcome to your own Website</h1>
        <p class="mb-6 text-black text-center">Discover our amazing features and benefits.</p>
        <a href="add_expense.php" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Add expenses</a>
    </div>
</div>


<div class="bg-gray-200 p-5 mt-5 shadow-lg rounded-lg w-11/12 md:w-7/10 lg:w-full mx-auto mb-13 break-words">
    <div class="flex flex-col lg:flex-row lg:gap-2 justify-around mb-5 text-center">
        <div class="bg-red-500 p-5 rounded-lg w-full mb-5 lg:mb-0 hover-grow transition-transform duration-300 ease-in-out">
            <h2 class="ml-5 mb-4 text-3xl font-bold">Daily Expenses</h2>
            <p class="text-xl mb-12">Total: <?php echo $daily_expenses; ?></p>
            <a href="view_daily_expenses.php" class="mr-2 p-3 rounded-lg no-underline bg-red-400 mb-6 text-white bg-green-900 hover:bg-green-600">>View Daily Expenses</a>
        </div>
        <div class="bg-yellow-600 p-5 py-10 rounded-lg w-full mb-5 lg:mb-0 hover-grow transition-transform duration-300 ease-in-out">
            <h2 class="ml-5 mb-4 text-3xl font-bold">Weekly Expenses</h2>
            <p class="text-xl mb-9">Total: <?php echo $weekly_expenses; ?></p>
            <a href="view_weekly_expenses.php" class="p-3 rounded-lg bg-red-400 mb-6 text-white bg-green-900 hover:bg-green-600">>View Weekly Expenses</a>
        </div>
        <div class="bg-gray-600 p-5 rounded-lg w-full hover-grow transition-transform duration-300 ease-in-out">
            <h2 class="ml-5 mb-4 text-3xl font-bold">Monthly Expenses</h2>
            <p class="text-xl mb-12">Total: <?php echo $monthly_expenses; ?></p>
            <a href="view_monthly_expenses.php" class="mr-2 p-3 rounded-lg bg-red-400 mb-6 text-white bg-green-900 hover:bg-green-600">>View Monthly Expense</a>
        </div>
    </div>

    <div class="actions flex flex-col justify-center gap-4 my-10 pt-16 lg:flex-row lg:gap-6 mt-6">
        <a href="add_expense.php" class="no-underline text-gray-300 text-2xl p-2 bg-purple-900 rounded-lg text-center mb-4 hover:bg-purple-600">Add Expense</a>
        <a href="view_expenses.php" class="no-underline text-gray-300 text-2xl p-2 bg-purple-900 rounded-lg text-center mb-4 hover:bg-purple-600">See All Expenses</a>
        <a href="settime.php" class="no-underline text-gray-300 text-2xl p-2 bg-purple-900 rounded-lg text-center mb-4 hover:bg-purple-600">Set Time</a>
    </div>
</div>

<?php
include 'include/footer.php'; 
?>

</body>
</html>