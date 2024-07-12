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

<div class="bg-white p-5 mt-5 shadow-lg rounded-lg w-11/12 md:w-7/10 lg:w-1/2 mx-auto mb-14 break-words hover-grow transition-transform duration-300 ease-in-out rounded-lg">
    <h1 class="ml-5 mb-9 text-3xl font-bold">Add Expense</h1>
    <form action="add_expense.php" method="POST">
        <input type="text" name="item_name" placeholder="Item Name" required class="block w-11/12 mb-4 ml-6 p-2 border border-gray-300 rounded-lg">
        <input type="number" name="amount" placeholder="Amount" required min="0" class="block w-11/12 mb-4 ml-6 p-2 border border-gray-300 rounded-lg">
        <input type="date" name="date" placeholder="Date" required class="block w-11/12 mb-4 ml-6 p-2 border border-gray-300 rounded-lg">
        <textarea name="description" placeholder="Description" required class="block w-11/12 mb-4 ml-6 p-2 border border-gray-300 rounded-lg"></textarea>
        <select name="category" required class="block w-11/12 mb-4 ml-6 p-2 border border-gray-300 rounded-lg">
            <option value="">catogery</option>
            <option value="food">Food</option>
            <option value="electricity">Electricity</option>
            <option value="transportation">Transportation</option>
            <option value="others">Others</option>
        </select>
        <button type="submit" class="block w-11/12 mb-4 ml-6 p-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700">Add Expense</button>
    </form>
</div>
<?php
 include 'include/footer.php'; 
?>
</body>
</html>