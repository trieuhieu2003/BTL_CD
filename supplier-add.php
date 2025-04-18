<?php
// Start the session.
session_start();
if (!isset($_SESSION['user'])) header('location: login.php');

$_SESSION['table'] = 'suppliers';
$_SESSION['redirect_to'] = 'supplier-add.php';

$user = $_SESSION['user'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Add Supplier - He Thong Quan Ly Kho</title>

    <link rel="stylesheet" href="css/user_add.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/product-add.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/css/bootstrap-dialog.min.css"
        integrity="sha512-PvZCtvQ6xGBLWHcXnyHD67NTP+a+bNrToMsIdX/NUqhw+npjLDhlMZ/PhSHZN4s9NdmuumcxKHQqbHlGVqc8ow=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div id="dashboardMainContainer">
        <?php include('partials/app_slidebar.php') ?>
        <div class="dashboard_content_container">
            <?php include('partials/app_topnav.php') ?>
            <div class="dashboard_content">
            <?php if(in_array('supplier_create',$user['permissions'])){?>

                <div class="dashboard_content_main">
                    <div class="row">
                        <div class="column column-12">
                            <h1 class="section_header"><i class="fa fa-plus"></i> Thêm nhà cung cấp</h1>

                            <div id="userAddFormContainer">
                                <form action="database/add.php" method="POST" class="appForm" enctype="multipart/form-data">
                                    <div class="appFormInputContainer">
                                        <label for="supplier_name">Tên nhà cung cấp</label>
                                        <input type="text" class="appFormInput" id="supplier_name" placeholder="Nhập tên nhà cung cấp..." name="supplier_name">
                                    </div>

                                    <div class="appFormInputContainer">
                                        <label for="supplier_location">Địa chỉ</label>
                                        <input type="text" class="appFormInput productTextAreaInput" placeholder="Nhập địa chỉ nhà cung cấp..." name="supplier_location" id="supplier_location"></input>

                                    </div>

                                    <div class="appFormInputContainer">
                                        <label for="email">Email</label>
                                        <input type="text" class="appFormInput productTextAreaInput" placeholder=" Nhập email nhà cung cấp..." name="email" id="email"></input>

                                    </div>
                                    <button type="submit" class="appBtn"><i class="fa-solid fa-user-plus"></i>Thêm nhà cung cấp</button>
                                </form>
                                <?php

                                if (isset($_SESSION['response'])) {
                                    $response_message = $_SESSION['response']['message'];
                                    $is_success = $_SESSION['response']['success'];
                                ?>
                                    <div class="responseMessage">
                                        <p
                                            class="responseMessage <?= $is_success ? 'responseMessage_success' : 'responseMessage_error' ?>">
                                            <?= htmlspecialchars($response_message) ?>
                                        </p>


                                    <?php unset($_SESSION['response']);
                                } ?>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } else {?>
                    <div id="errorMessage">
                        Không được cho phép
                    </div>
                <?php } ?>
            </div>
        </div>

    </div>
    <script src="js/script.js">
    </script>

    </div>
</body>

</html>