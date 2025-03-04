<?php
    session_start();
    
    if (!isset($_SESSION['user'])) header("Location: login.php");
        
    

    $user = $_SESSION['user'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - He Thong Quan Ly Kho</title>

    <link rel="stylesheet" href="css/login.css">
    <!-- <link rel="stylesheet" href="css/dashboard.css"> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <div id="dashboardMainContainer">
        <?php include('partials/app_slidebar.php')?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <div class="dashboard_content">
                <?php include('partials/app_topnav.php')?>
                <div class="dashboard_content_main">

                </div>
            </div>
        </div>
        <script src="js/script.js">
        </script>
    </div>
</body>

</html>
