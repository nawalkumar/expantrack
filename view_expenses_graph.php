<?php
include 'include/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$view_type = isset($_GET['view']) ? $_GET['view'] : 'daily';

$interval = '';
switch ($view_type) {
    case 'weekly':
        $interval = 'INTERVAL 7 DAY';
        break;
    case 'monthly':
        $interval = 'INTERVAL 30 DAY';
        break;
    case 'daily':
    default:
        $interval = 'INTERVAL 1 DAY';
        break;
}

$sql_category = "SELECT category, SUM(amount) as total_amount FROM expenses 
                 WHERE user_id='$user_id' AND date >= DATE_SUB(CURDATE(), $interval) 
                 GROUP BY category";

$result_category = $conn->query($sql_category);

$categoryDataPoints = [];
if ($result_category->num_rows > 0) {
    while ($row = $result_category->fetch_assoc()) {
        $categoryDataPoints[] = ['label' => ($row['category']), 'y' => $row['total_amount']];
    }
}

$sql_daily = "SELECT DATE(date) as expense_date, SUM(amount) as total_amount FROM expenses 
              WHERE user_id='$user_id' AND date >= DATE_SUB(CURDATE(), $interval) 
              GROUP BY DATE(date)";

$result_daily = $conn->query($sql_daily);

$dailyDataPoints = [];
if ($result_daily->num_rows > 0) {
    while ($row = $result_daily->fetch_assoc()) {
        $dailyDataPoints[] = ['label' => $row['expense_date'], 'y' => $row['total_amount']];
    }
}

$sql_time = "SELECT DATE_FORMAT(date, '%H:%i') as expense_time, SUM(amount) as total_amount FROM expenses 
             WHERE user_id='$user_id' AND DATE(date) = CURDATE()
             GROUP BY HOUR(date), MINUTE(date)";

$result_time = $conn->query($sql_time);

$timeDataPoints = [];
if ($result_time->num_rows > 0) {
    while ($row = $result_time->fetch_assoc()) {
        $timeDataPoints[] = ['label' => $row['expense_time'], 'y' => $row['total_amount']];
    }
}
?>

<div class="bg-white p-5 mt-5 shadow-lg rounded-lg w-11/12 md:w-7/10 lg:w-9/10 mx-auto  break-words rounded-lg">
    <h1 class="ml-5 mb-4 text-3xl font-bold"><?php echo ucfirst($view_type); ?> Expenses Graph</h1>
    <div class="flex flex-col lg:flex-row lg:gap-6">
        <div id="chartContainerCategory" class="w-full lg:w-1/2" style="height: 370px;"></div>
        <?php if ($view_type != 'daily'): ?>
            <div id="chartContainerDaily" class="w-full lg:w-1/2" style="height: 370px; margin-top: 30px;"></div>
        <?php endif; ?>
        <?php if ($view_type == 'daily'): ?>
            <div id="chartContainerTime" class="w-full lg:w-1/2" style="height: 370px; margin-top: 30px;"></div>
        <?php endif; ?>
    </div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script>
        window.onload = function () {
            var chartCategory = new CanvasJS.Chart("chartContainerCategory", {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "<?php echo ucfirst($view_type); ?> Expenses by Category"
                },
                axisY: {
                    title: "Amount"
                },
                data: [{
                    type: "column",
                    yValueFormatString: "#,##0.##",
                    dataPoints: <?php echo json_encode($categoryDataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chartCategory.render();

            <?php if ($view_type != 'daily'): ?>
                var chartDaily = new CanvasJS.Chart("chartContainerDaily", {
                    animationEnabled: true,
                    theme: "light2",
                    title: {
                        text: "<?php echo ucfirst($view_type); ?> Expenses by Day"
                    },
                    axisY: {
                        title: "Amount"
                    },
                    axisX: {
                        title: "Date"
                    },
                    data: [{
                        type: "line",
                        yValueFormatString: "#,##0.##",
                        dataPoints: <?php echo json_encode($dailyDataPoints, JSON_NUMERIC_CHECK); ?>
                    }]
                });
                chartDaily.render();
            <?php endif; ?>

            <?php if ($view_type == 'daily'): ?>
                var chartTime = new CanvasJS.Chart("chartContainerTime", {
                    animationEnabled: true,
                    theme: "light2",
                    title: {
                        text: "Daily Expenses by Time"
                    },
                    axisY: {
                        title: "Amount"
                    },
                    axisX: {
                        title: "Time"
                    },
                    data: [{
                        type: "line",
                        yValueFormatString: "#,##0.##",
                        dataPoints: <?php echo json_encode($timeDataPoints, JSON_NUMERIC_CHECK); ?>
                    }]
                });
                chartTime.render();
            <?php endif; ?>
        }
    </script>

    <div class="actions flex flex-col justify-center gap-10 mt-16 pt-16 lg:flex-row lg:gap-6 mt-6">
        <a href="view_daily_expenses.php" class="no-underline text-gray-300 text-2xl p-2 bg-purple-900 rounded-lg text-center mb-4 hover:bg-purple-600">Daily Expenses</a>
        <a href="view_weekly_expenses.php" class="no-underline text-gray-300 text-2xl p-2 bg-purple-900 rounded-lg text-center mb-4 hover:bg-purple-600">Weekly Expenses</a>
        <a href="view_monthly_expenses.php" class="no-underline text-gray-300 text-2xl p-2 bg-purple-900 rounded-lg text-center mb-4 hover:bg-purple-600">Monthly Expenses</a>
    </div>
</div>

<?php include 'include/footer.php'; ?>

</body>
</html>
