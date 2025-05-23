<?php
// Start the session.
session_start();
if (!isset($_SESSION['user']))
    header('location: login.php');

$_SESSION['table'] = 'users';
$_SESSION['redirect_to'] = 'user_add.php';

$show_table = 'users';

$users = include('database/show.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> User add - He Thong Quan Ly Kho</title>

    <link rel="stylesheet" href="css/user_add.css">
    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <?php if(in_array('user_create',$user['permissions'])){?>

                <div class="dashboard_content_main">
                    <div class="row">
                        <div class="column column-12">
                            <h1 class="section_header"><i class="fa fa-plus"></i> Thêm người dùng</h1>
                            <div id="userAddFormContainer">
                                <form action="database/add.php" method="POST" class="appForm">
                                    <div class="appFormInputContainer">
                                        <label for="first_Name">Họ</label>
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
                                    <input type="hidden" id="permission_el" name="permissions">
                                    <?php include('partials/permissions.php') ?>
                                    <input type="hidden" name="table" value="users">
                                    <button type="submit" class="appBtn"><i class="fa-solid fa-user-plus"></i>Add
                                        User</button>
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
    <script>
        function loadScript() {
            this.permissions = [];

            this.initialize = function () {

                this.registerEvents();
            },

                this.registerEvents = function () {
                    document.addEventListener('click', function (e) {
                        let target = e.target;

                        if (target.classList.contains('moduleFunc')) {
                            let permissionName = target.dataset.value;

                            if (target.classList.contains('permissionActive')) {
                                target.classList.remove('permissionActive');

                                script.permissions = script.permissions.filter((name) => {
                                    return name !== permissionName;
                                });
                            } else {
                                target.classList.add('permissionActive');
                                script.permissions.push(permissionName);
                            }

                            document.getElementById('permission_el')
                                .value = script.permissions.join(',');
                        }
                    });
                }
        }

        var script = new loadScript;
        script.initialize();
    </script>
</body>

</html>