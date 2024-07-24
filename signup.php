<?php
include 'include/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $mobile = $_POST['mobile'];

    $sql = "INSERT INTO users (name, email, password, age, gender, mobile) VALUES ('$name', '$email', '$password', '$age', '$gender', '$mobile')";

    if ($conn->query($sql) === TRUE) {
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<div class="bg-white p-5 mt-5 shadow-lg rounded-lg w-11/12 md:w-7/10 lg:w-1/2 mx-auto mb-14 break-words hover-grow transition-transform duration-300 ease-in-out rounded-lg">
    <h1  class="ml-5 mb-12 text-4xl font-bold">Sign Up</h1>
    <form id="signupForm" action="signup.php" method="POST">
        <input type="text" name="name" placeholder="Name" required pattern="[A-Za-z\s]{1,}" class="block w-11/12 mb-4 ml-6 p-2 border border-gray-300 rounded-lg">
        <input type="email" name="email" placeholder="Email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" class="block w-11/12 mb-4 ml-6 p-2 border border-gray-300 rounded-lg">
        <input type="password" name="password" id="password" placeholder="Password" required pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{6,}$" title="Password must be at least 6 characters long and include at least one letter, one number, and one special character." class="block w-11/12 mb-4 ml-6 p-2 border border-gray-300 rounded-lg">
        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{6,}$" title="Password must be at least 6 characters long and include at least one letter, one number, and one special character." class="block w-11/12 mb-4 ml-6 p-2 border border-gray-300 rounded-lg">
        <input type="number" name="age" placeholder="Age" required min="1" max="150" class="block w-11/12 mb-4 ml-6 p-2 border border-gray-300 rounded-lg">
        <select name="gender" required class="block w-11/12 mb-4 ml-6 p-2 border border-gray-300 rounded-lg">
            <option value="" disabled selected>Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
        <input type="text" name="mobile" placeholder="Mobile" required pattern="\d{10}" class="block w-11/12 mb-4 ml-6 p-2 border border-gray-300 rounded-lg">
        <button type="submit" class="block w-11/12 mb-4 ml-6 p-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700 ">Sign Up</button>
    </form>
    <a href="login.php" class="text-black no-underline mr-5 font-bold hover:underline">Already have an account? Login</a>
</div>

<script>
document.getElementById('signupForm').addEventListener('submit', function(event) {
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm_password').value;
    
    if (password !== confirmPassword) {
        alert("Passwords do not match. Please try again.");
        event.preventDefault();
    }
});
</script>
<?php
 include 'include/footer.php'; 
?>
</body>
</html>
