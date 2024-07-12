<?php
include 'include/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: dashboard.php');
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with this email.";
    }
}

?>

<div class="bg-white p-5 mt-5 shadow-lg rounded-lg w-11/12 md:w-7/10 lg:w-1/2 mx-auto mb-14 break-words hover-grow transition-transform duration-300 ease-in-out rounded-lg">
    <h1 class="ml-5 mb-12 text-4xl font-bold">Login</h1>
    <form action="login.php" method="POST">
        <input type="email" name="email" placeholder="Email" required class="block w-11/12 mb-4 ml-6 p-2 border border-gray-300 rounded-lg">
        <input type="password" name="password" placeholder="Password" required class="block w-11/12 mb-4 ml-6 p-2 border border-gray-300 rounded-lg">
        <button type="submit" class="block w-11/12 mb-4 ml-6 p-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700 ">Login</button>
    </form>
    <a href="signup.php" class="text-black no-underline mr-5 font-bold hover:underline">Don't have an account? Sign Up</a>
</div>
<?php
 include 'include/footer.php'; 
?>
</body>
</html>
