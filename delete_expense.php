<?php
include 'include/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$expense_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$sql = "DELETE FROM expenses WHERE id='$expense_id' AND user_id='$user_id'";

if ($conn->query($sql) === TRUE) {
    header('Location: view_expenses.php');
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>

<?php
 include 'include/footer.php'; 
?>