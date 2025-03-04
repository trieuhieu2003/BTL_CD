<?php
session_start();
if (!isset($_SESSION['user']))
    header('location: login.php');
$_SESSION['table'] = 'users';
$user = $_SESSION['user'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - He Thong Quan Ly Kho</title>

    <link rel="stylesheet" href="css/user_add.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"
        integrity="sha512-b+nQTCdtTBIRIbraqNEwsjB6UvL3UEMkXnhzd8awtCYh0Kcsjl9uEgwVFVbhoj3uu1DO1ZMacNvLoyJJiNfcvg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
</head>

<body>
    <div id="dashboardMainContainer">
        <?php include('partials/app_slidebar.php') ?>
        <div class="dashboard_content_container">
            <?php include('partials/app_topnav.php') ?>
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <div class="row">
                        <div class="column column-5">
                            <h1 class="section_header"><i class="fa fa-plus"></i> Thêm người dùng</h1>

                            <div id="userAddFormContainer">
                                <form action="database/add.php" method="POST" class="appForm">
                                    <div class="appFormInputContainer">
                                        <label for="firt_Name">Họ</label>
                                        <input type="text" class="appFormInput" id="first_Name" name="first_name">
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="last_Name">Tên</label>
                                        <input type="text" class="appFormInput" id="last_Name" name="last_name">
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="email">Email</label>
                                        <input type="text" class="appFormInput" id="email" name="email">
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="password">Mật Khẩu</label>
                                        <input type="password" class="appFormInput" id="password" name="password">
                                    </div>
                                    <input type="hidden" name="table" value="users">
                                    <button type="submit" class="appBtn"><i class="fa-solid fa-user-plus"></i>Add User</button>
                                </form>
                                <?php

                                if (isset($_SESSION['response'])) {
                                    $response_message = $_SESSION['response']['message'];
                                    $is_success = $_SESSION['response']['success'];
                                ?>
                                    <div class="responseMessage">
                                        <p class="responseMessage <?= $is_success ? 'responseMessage_success' : 'responseMessage_error' ?>"><?= htmlspecialchars($response_message) ?></p>


                                    <?php unset($_SESSION['response']);
                                } ?>
                                    </div>
                            </div>
                        </div>
                        <div class="column column-7">
                            <h1 class="section_header"><i class="fa fa-list"></i> Danh sách người dùng</h1>
                            <div class="section_content">
                                <div class="users">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Họ</th>
                                                <th>Tên</th>
                                                <th>Email</th>
                                                <th>Ngày tạo</th>
                                                <th>Ngày cập nhật</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Tran</td>
                                                <td>Dung</td>
                                                <td>trandung@email.com</td>
                                                <td>February 25, 2025 @ 5:00PM</td>
                                                <td>February 25, 2025 @ 5:30PM</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>


    <script src="js/script.js">
    </script>
    <script src="js/jquery/jquery-3.7.1.min.js"></script>
    <script>
        function script() {

            this.initialize = function() {
                    this.registerEvents();
                },

                this.registerEvents = function() {
                    document.addEventListener('click', function(e) {
                        targetElement = e.target;
                        classList = targetElement.classList;

                        classlíst = e.target.classList;
                        if (classList.contains('deleteUser')) {

                            e.preventDefault();
                            userId = targetElement.dataset.userid;
                            fname = targetElement.dataset.fname;
                            lname = targetElement.dataset.lname;

                            if (window.confirm('Bạn có muốn xoá không ' + fullName + '?')) {
                                $.ajax({
                                    method: 'POST',
                                    data: {
                                        user_id: userId
                                    },
                                    url: 'database/delete-user.php'
                                })
                            } else {
                                console.log('Không xoá')
                            }
                        }

                    });
                }
        }
    </script>
    </div>
</body>

</html>