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
        $sort_query = "ORDER BY date DESC"; // Default sorting by date descending
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

<div class="container3">
    <h1>Monthly Expenses (<?php echo date('F Y', strtotime($start_date)); ?>)</h1>
    <button onclick="window.location.href='view_expenses_graph.php?view=monthly'">View Graphical Representation</button>

    <!-- Filter and Sort Options -->
    <div class="filter-sort-options">
        <div class="filter">
            <label>Filter by Category:</label>
            <!-- <select onchange="filterExpenses(this.value)">
                <option value="all" <?php if ($filter_category == 'all') echo 'selected'; ?>>All</option>
                <?php while ($category = $result_categories->fetch_assoc()): ?>
                    <option value="<?php echo $category['category']; ?>" <?php if ($filter_category == $category['category']) echo 'selected'; ?>>
                        <?php echo ucfirst($category['category']); ?>
                    </option>
                <?php endwhile; ?>
            </select> -->
            <select onchange="filterExpenses(this.value)">
                <option value="all">All</option>
                <option value="food" <?php if ($filter_category == 'food') echo 'selected'; ?>>Food</option>
                <option value="electricity" <?php if ($filter_category == 'electricity') echo 'selected'; ?>>Electricity</option>
                <option value="transportation" <?php if ($filter_category == 'transportation') echo 'selected'; ?>>Transportation</option>
                <option value="others" <?php if ($filter_category == 'others') echo 'selected'; ?>>Others</option>
            </select>
        </div>
        <div class="sort">
            <label>Sort by:</label>
            <select onchange="sortExpenses(this.value)">
                <option value="date_desc" <?php if ($sort_by == 'date_desc') echo 'selected'; ?>>Date (Newest First)</option>
                <option value="amount_asc" <?php if ($sort_by == 'amount_asc') echo 'selected'; ?>>Amount (Low to High)</option>
                <option value="amount_desc" <?php if ($sort_by == 'amount_desc') echo 'selected'; ?>>Amount (High to Low)</option>
                <option value="category_asc" <?php if ($sort_by == 'category_asc') echo 'selected'; ?>>Category (A to Z)</option>
                <option value="category_desc" <?php if ($sort_by == 'category_desc') echo 'selected'; ?>>Category (Z to A)</option>
            </select>
        </div>
    </div>

    <div class="expenses-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($expense = $result->fetch_assoc()): ?>
                <div class="expense-item">
                    <h2><?php echo htmlspecialchars($expense['item_name']); ?></h2>
                    <p>Amount: <?php echo $expense['amount']; ?></p>
                    <p>Date: <?php echo $expense['date']; ?></p>
                    <p>Description: <?php echo htmlspecialchars($expense['description']); ?></p>
                    <p>Category: <?php echo ucfirst($expense['category']); ?></p>
                    <a href="edit_expense.php?id=<?php echo $expense['id']; ?>">Edit</a>
                    <a href="delete_expense.php?id=<?php echo $expense['id']; ?>" onclick="return confirm('Are you sure you want to delete this expense?')">Delete</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No expenses found for this month.</p>
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
