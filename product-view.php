product-view.php<?php
session_start();
if(|isset($SESSION['user'])) header('location: login.php');
$_SESSION['table'] = 'users';
$user = $_SESSION['user'];
$user = include('database/show-users.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Xem Người dùng - Hệ thống quản lý hàng tồn kho</title>
        <?php include('pantials/app-header-scripts.php'); ?>
    </head>
    <body>
        <div id="dashboardMainContainer">
            <?php('pantials/app-sidebar.php')?>
            <div class="dashboard_content_main">
                <div class="row">
                    <div class="column column-12">
                        <h1 class="section_header"><i class="fa fa-list"></i>Danh sách người dùng</h1>
                        <div class="section_content">
                            <div class="users">
                                <table>
                                    <thead>
                                        <tr>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>

                            </div>

                        </div>

                </div>

            </div>

        </div>
    </body>
</html>
