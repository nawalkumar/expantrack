<?php
 include 'include/header.php'; 
?>
<div class="bg-red-300 p-5 mt-5 shadow-lg  rounded-lg w-11/12 md:w-7/10 lg:w-4/5 mt-12 mb-16 break-words hover-grow transition-transform duration-300 ease-in-out rounded-lg">
    <h1 class="ml-5 mb-4 text-3xl font-bold">Welcome to Expense Tracker</h1>
    <p class="text-xl mb-3">Track your expenses with easy steps</p>
    <button><a href="signup.php" class="text-blue-800 no-underline mr-5 font-bold hover:underline">Sign Up</a></button> | <button><a href="login.php" class="text-blue-800 no-underline mr-5 font-bold hover:underline">Login</a></button>
</div>
<div class="container flex bg-red-300 p-5 mb-18   wrap">
        <div class="flex flex-col p-4 hover-grow transition-transform duration-300 ease-in-out rounded-lg">
            <h2 class="text-3xl font-bold mb-4 mt-12 ml-6 text-left ">Manage your expenses from <br> anywhere in real time </h2>
            <p class="text-gray-700 text-left mt-12 ml-6">boost your productivity to automiting your<br> expenses management process, you can see your expenses details on simple clicks.</p>
        </div>

        <div class="flex justify-center  p-4  ">
            <img src="include/assets/image1.jpg" alt="Placeholder Image" class="hover-grow transition-transform duration-300 ease-in-out rounded-lg">
        </div>
</div>

<?php
 include 'include/footer.php'; 
?>
</body>
</html>
