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
        $interval = 'INTERVAL 0 DAY';
        break;
}

$sql = "SELECT category, SUM(amount) as total_amount FROM expenses 
        WHERE user_id='$user_id' AND date >= DATE_SUB(CURDATE(), $interval) 
        GROUP BY category";

$result = $conn->query($sql);

$dataPoints = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dataPoints[] = ['label' => ($row['category']), 'y' => $row['total_amount']];
    }
}
//echo "<pre>dataPoints: " . print_r($dataPoints, true) . "</pre>";
?>

<div class="container">
    <h1><?php echo ($view_type); ?> Expenses Graph</h1>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script>
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "<?php echo ($view_type); ?> Expenses"
                },
                axisY: {
                    title: "Amount"
                },
                data: [{
                    type: "column",
                    yValueFormatString: "#,##0.##",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
        }
    </script>
    <div class="actions">
        <a href="view_daily_expenses.php">Daily Expenses</a>
        <a href="view_weekly_expenses.php">Weekly Expenses</a>
        <a href="view_monthly_expenses.php">Monthly Expenses</a>
    </div>
</div>

<?php include 'include/footer.php'; ?>
</body>
</html>
