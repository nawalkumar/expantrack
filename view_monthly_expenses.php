<?php
include 'include/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['user_id'];

// Handle sorting
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'date_desc';
$sort_query = '';

switch ($sort_by) {
    case 'amount_asc':
        $sort_query = "ORDER BY amount ASC";
        break;
    case 'amount_desc':
        $sort_query = "ORDER BY amount DESC";
        break;
    case 'category_asc':
        $sort_query = "ORDER BY category ASC";
        break;
    case 'category_desc':
        $sort_query = "ORDER BY category DESC";
        break;
    default:
        $sort_query = "ORDER BY date DESC";
        break;
}

// Handle category filter
$filter_category = isset($_GET['filter_category']) ? $_GET['filter_category'] : 'all';
$filter_query = '';

if ($filter_category != 'all') {
    $filter_query = "AND category='$filter_category'";
}

// Calculate start and end dates of current month
$start_date = date('Y-m-01');
$end_date = date('Y-m-t');


$sql = "SELECT * FROM expenses WHERE user_id='$user_id' AND date BETWEEN '$start_date' AND '$end_date' $filter_query $sort_query";
$result = $conn->query($sql);


$sql_categories = "SELECT DISTINCT category FROM expenses WHERE user_id='$user_id'";
$result_categories = $conn->query($sql_categories);
?>

<div class="bg-green-500 p-5 mt-5 shadow-lg rounded-lg w-11/12 md:w-7/10 lg:w-4/5 mx-auto mb-14 break-words hover-grow transition-transform duration-300 ease-in-out rounded-lg">
    <h1 class="ml-5 mb-9 text-3xl font-bold">Monthly Expenses (<?php echo date('F Y', strtotime($start_date)); ?>)</h1>
    <button onclick="window.location.href='view_expenses_graph.php?view=monthly'" class="mr-2 p-1 bg-red-400 mb-6 text-white hover:bg-red-600">View Graphical Representation</button>

    <!-- Filter and Sort Options -->
    <div class="filter-form mb-5 flex flex-col lg:flex-row justify-between items-center">
        <div class="filter flex flex-col lg:flex-row items-center">
            <label class="mr-2 font-bold">Filter by Category:</label>
            <!-- <select onchange="filterExpenses(this.value)">
                <option value="all" <?php if ($filter_category == 'all') echo 'selected'; ?>>All</option>
                <?php while ($category = $result_categories->fetch_assoc()): ?>
                    <option value="<?php echo $category['category']; ?>" <?php if ($filter_category == $category['category']) echo 'selected'; ?>>
                        <?php echo ucfirst($category['category']); ?>
                    </option>
                <?php endwhile; ?>
            </select> -->
            <select  class="mr-2 p-1 mb-2 lg:mb-0" onchange="filterExpenses(this.value)">
                <option value="all">All</option>
                <option value="food" <?php if ($filter_category == 'food') echo 'selected'; ?>>Food</option>
                <option value="electricity" <?php if ($filter_category == 'electricity') echo 'selected'; ?>>Electricity</option>
                <option value="transportation" <?php if ($filter_category == 'transportation') echo 'selected'; ?>>Transportation</option>
                <option value="others" <?php if ($filter_category == 'others') echo 'selected'; ?>>Others</option>
            </select>
        </div>
        <div class="sort flex flex-col lg:flex-row items-center mb-4 lg:mb-0">
            <label class="mr-2 font-bold">Sort by:</label>
            <select  class="mr-2 p-1 mb-2 lg:mb-0" onchange="sortExpenses(this.value)">
                <option value="date_desc" <?php if ($sort_by == 'date_desc') echo 'selected'; ?>>Date (Newest First)</option>
                <option value="amount_asc" <?php if ($sort_by == 'amount_asc') echo 'selected'; ?>>Amount (Low to High)</option>
                <option value="amount_desc" <?php if ($sort_by == 'amount_desc') echo 'selected'; ?>>Amount (High to Low)</option>
                <option value="category_asc" <?php if ($sort_by == 'category_asc') echo 'selected'; ?>>Category (A to Z)</option>
                <option value="category_desc" <?php if ($sort_by == 'category_desc') echo 'selected'; ?>>Category (Z to A)</option>
            </select>
        </div>
    </div>

    <div class="expenses-container flex flex-col text-center">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($expense = $result->fetch_assoc()): ?>
                <div class="expense-item bg-gray-200 p-2 rounded-lg mb-4">
                    <h2 class="mt-0"><?php echo htmlspecialchars($expense['item_name']); ?></h2>
                    <p>Amount: <?php echo $expense['amount']; ?></p>
                    <p>Date: <?php echo $expense['date']; ?></p>
                    <p>Description: <?php echo htmlspecialchars($expense['description']); ?></p>
                    <p>Category: <?php echo ucfirst($expense['category']); ?></p>
                    <a href="edit_expense.php?id=<?php echo $expense['id']; ?>" class="no-underline text-blue-500 hover:underline">Edit</a>
                    <a href="delete_expense.php?id=<?php echo $expense['id']; ?>" class="no-underline text-blue-500 hover:underline" onclick="return confirm('Are you sure you want to delete this expense?')">Delete</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-xl mb-3">No expenses found for this month.</p>
        <?php endif; ?>
    </div>
</div>

<script>
   
    function filterExpenses(category) {
        window.location.href = 'view_monthly_expenses.php?filter_category=' + category;
    }

    
    function sortExpenses(sortBy) {
        window.location.href = 'view_monthly_expenses.php?sort_by=' + sortBy;
    }
</script>
<?php
 include 'include/footer.php'; 
?>
</body>
</html>
