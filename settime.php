<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Dashboard</title>
</head>
<?php include 'include/header.php' ?>
<body class=" h-screen flex justify-center items-center" style="background-image: url('include/assets/hero.jpg'); height:80vh;" >

<div class="contain mx-auto mt-60 p-12 ">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Set Daily Expense Reminder</h2>
        <div class="mb-4">
            <label for="time" class="block text-gray-700">Select Time:</label>
            <input type="time" id="time" name="time" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <button id="setReminder" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Set Reminder</button>
    </div>
</div>

<script>
    document.getElementById('setReminder').addEventListener('click', function () {
        const time = document.getElementById('time').value;
        if (time) {
            localStorage.setItem('reminderTime', time);
            alert('Reminder set for ' + time);
            checkReminder();
        } else {
            alert('Please select a time.');
        }
    });

    function checkReminder() {
        const reminderTime = localStorage.getItem('reminderTime');
        if (reminderTime) {
            const now = new Date();
            const currentTime = now.getHours() + ':' + String(now.getMinutes()).padStart(2, '0');

            if (currentTime === reminderTime) {
                alert('Please add your expenses to better track your expenses.');
            }
        }
    }

    setInterval(checkReminder, 60000); // Check every minute
</script>
<?php include 'include/footer.php' ?>
</body>
</html>
