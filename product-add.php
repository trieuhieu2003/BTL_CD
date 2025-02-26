product-view.php
<?php
session_start();
if(|isset($SESSION['user'])) header('location: login.php');
$_SESSION['table'] = 'users';
$user = $_SESSION['user'];
$user = include('database/show-users.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Xem Sản Phẩm - Hệ thống quản lý hàng tồn kho</title>
        <?php include('pantials/app-header-scripts.php'); ?>
    </head>
    <body>
        <div id="dashboardMainContainer">
            <?php('pantials/app-sidebar.php')?>
            <div class="dashboard_content_main">
                <div class="row">
                    <div class="column column-12">
                        <h1 class="section_header"><i class="fa fa-list"></i>Danh sách sản phẩm</h1>
                        <div id="userAddFromIputContainer">
                            <from>
                                
                            </from> 

                        </div>

                </div>

            </div>

        </div>
    </body>
</html>

