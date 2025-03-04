<?php
// Start the session.
session_start();
if (!isset($_SESSION['user'])) header('location: login.php');

$_SESSION['table'] = 'products';
$_SESSION['redirect_to'] = 'product-add.php';

$user = $_SESSION['user'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Add Product - He Thong Quan Ly Kho</title>

    <link rel="stylesheet" href="css/user_add.css">
    <link rel="stylesheet" href="css/login.css">
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
                <div class="dashboard_content_main">
                    <div class="row">
                        <div class="column column-12">
                            <h1 class="section_header"><i class="fa fa-plus"></i> Thêm sản phẩm</h1>

                            <div id="userAddFormContainer">
                                <form action="database/add.php" method="POST" class="appForm">
                                    <div class="appFormInputContainer">
                                        <label for="product_name">Tên sản phẩm</label>
                                        <input type="text" class="appFormInput" id="product_name" placeholder="Nhập tên sản phẩm..." name="product_name">
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="description">Mô tả</label>
                                        <textarea class="appFormInput productTextAreaInput" placeholder="Mô tả sản phẩm..." name="description" id="description">

                                        </textarea>
                                    </div>


                                    <button type="submit" class="appBtn"><i class="fa-solid fa-user-plus"></i>Thêm sản
                                        phẩm</button>
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
            </div>
        </div>

    </div>

    </div>
</body>

</html>