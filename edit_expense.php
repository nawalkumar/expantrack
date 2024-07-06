<?php
include 'include/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$expense_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Fetch expense details
$sql = "SELECT * FROM expenses WHERE id='$expense_id' AND user_id='$user_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    header('Location: view_expenses.php');
    exit();
}

$expense = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_name = $_POST['item_name'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $description = $_POST['description'];
    $category = $_POST['category']; 

    $sql = "UPDATE expenses SET item_name='$item_name', amount='$amount', date='$date', description='$description', category='$category' WHERE id='$expense_id'";

    if ($conn->query($sql) === TRUE) {
        header('Location: view_expenses.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<div class="container">
    <h1>Edit Expense</h1>
    <form action="edit_expense.php?id=<?php echo $expense_id; ?>" method="POST">
        <input type="text" name="item_name" placeholder="Item Name" value="<?php echo htmlspecialchars($expense['item_name']); ?>" required>
        <input type="number" name="amount" placeholder="Amount" value="<?php echo $expense['amount']; ?>" required min= "0">
        <input type="date" name="date" placeholder="Date" value="<?php echo $expense['date']; ?>" required>
        <textarea name="description" placeholder="Description" required><?php echo htmlspecialchars($expense['description']); ?></textarea>
        <select name="category" required>
            <option value="food" <?php if ($expense['category'] == 'food') echo 'selected'; ?>>Food</option>
            <option value="electricity" <?php if ($expense['category'] == 'electricity') echo 'selected'; ?>>Electricity</option>
            <option value="transportation" <?php if ($expense['category'] == 'transportation') echo 'selected'; ?>>Transportation</option>
            <option value="others" <?php if ($expense['category'] == 'others') echo 'selected'; ?>>Others</option>
        </select>
        <button type="submit">Update Expense</button>
    </form>
</div>
<?php
 include 'include/footer.php'; 
?>
</body>
</html>
