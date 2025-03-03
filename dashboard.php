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
        <div class="dashboard_sidebar" id="dashboard_sidebar">
            <h3 class="dashboard_logo" id="dashboard_logo">IMS</h3>
            <div class="dashboard_sidebar_user">
                <img src="images\user\DSCF1892.jpg" alt="User image." id="userImage" />
                <span><?= $user['first_name'] . ' ' . $user['last_name']?></span>
            </div>
            <div class="dashboard_sidebar_menus">
                <ul class="dashboard_menu_lists">
                    <li class="menuActive">
                        <a href=""><i class="fas fa-dashboard"></i><span class="menuText"> Dashboard</span></a>
                    </li>
                    <li>
                        <a href=""><i class="fas fa-gauge"></i><span class="menuText"> Dashboard</span></a>
                    </li>
                    <li>
                        <a href=""><i class="fas fa-gauge"></i><span class="menuText"> Dashboard</span></a>
                    </li>
                    <li>
                        <a href=""><i class="fas fa-gauge"></i><span class="menuText"> Dashboard</span></a>
                    </li>
                    <li>
                        <a href=""><i class="fas fa-gauge"></i><span class="menuText"> Dashboard</span></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <div class="dashboard_topNav">
                <a href="" id="toggleBtn"><i class="fas fa-bars"></i></a>
                <a href="database/logout.php" id="logoutBtn"><i class="fas fa-power-off"></i> Đăng xuất</a>
            </div>
            <div class="dashboard_content">
                <div class="dashboard_content_main">

                </div>
            </div>
        </div>
        <script src="js/script.js">
        </script>
    </div>
</body>

</html>
