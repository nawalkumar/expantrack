<?php
include 'include/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_name = $_POST['item_name'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $description = $_POST['description'];
    $category = $_POST['category']; 
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO expenses (user_id, item_name, amount, date, description, category) VALUES ('$user_id', '$item_name', '$amount', '$date', '$description', '$category')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New expense added');</script>";
        header('Location: view_expenses.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<div class="container">
    <h1>Add Expense</h1>
    <form action="add_expense.php" method="POST">
        <input type="text" name="item_name" placeholder="Item Name" required>
        <input type="number" name="amount" placeholder="Amount" required min="0">
        <input type="date" name="date" placeholder="Date" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <select name="category" required>
            <option value="">catogery</option>
            <option value="food">Food</option>
            <option value="electricity">Electricity</option>
            <option value="transportation">Transportation</option>
            <option value="others">Others</option>
        </select>
        <button type="submit">Add Expense</button>
    </form>
</div>
<?php
 include 'include/footer.php'; 
?>
</body>
</html>