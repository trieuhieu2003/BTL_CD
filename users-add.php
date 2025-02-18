<?php
    session_start();
    if (isset($_SESSION['user'])) header('location: login.php');
        $_SESSION['table'] = 'users';
        $user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">    
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard - Inventory Management System</title>
        <link rel="stylesheet" href="css/login.css" type=" text/css">
        <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
    </head>
    <body>
        <div id="dashboardMainContainer">
            <?php include 'partials/app-sidebar.php'; ?>
            <h1>Add User</h1>
            <form action="database/add.php" method="POST">
                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="last_name" placeholder="Last Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Add User</button>
            </form>
            <a href="users.php">Back to Users</a>
        </div>
    </body>