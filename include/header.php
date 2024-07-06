<?php
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eTrack</title>
    <link rel="stylesheet" href="include/assets/styles.css">
</head>
<body>
    <div class="header">
        <h1>eTrack</h1>
        <nav>
            
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="index.php">Home</a>
                <a href="signup.php">Sign Up</a>
                <a href="login.php">Login</a>
            <?php else: ?>
                <a href="dashboard.php">Dashboard</a>
                <a href="logout.php">Logout</a>
            <?php endif; ?>
        </nav>
    </div>