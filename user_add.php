<?php
session_start();

if (!isset($_SESSION['user']))
    header('location: login.php');
$_SESSION['table'] = 'users';
$user = $_SESSION['user'];
$users = include('database/show-users.php');

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
                                                <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($users as $index => $user) { ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td><?= $user['first_name'] ?></td>
                                                    <td><?= $user['last_name'] ?></td>
                                                    <td><?= $user['email'] ?></td>
                                                    <td><?= date('M d,Y @ h:i:s A', strtotime($user['created_at'])) ?></td>
                                                    <td><?= date('M d,Y @ h:i:s A', strtotime($user['updated_at'])) ?></td>

                                                    <td>
                                                        <a href=""><i class="fa fa-pencil"></i>Sửa</a>
                                                        <a href="" class="deleteUser" data-userid="<?= $user['id'] ?>" data-fname="<?= $user['first_name'] ?>" data-lname="<?= $user['last_name'] ?>"><i class="fa fa-trash"></i>Xoá</a>
                                                    </td>
s

                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                    <p class="userCount"><?= count($users) ?> Người dùng</p>
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

                        if (classList.contains('deleteUser')) {

                            e.preventDefault();
                            userId = targetElement.dataset.userid;
                            fname = targetElement.dataset.fname;
                            lname = targetElement.dataset.lname;
                            fullName = fname + ' ' + lname;

                            if (window.confirm('Bạn có muốn xoá không ' + fullName + '?')) {
                                $.ajax({
                                    method: 'POST',
                                    data: {
                                        user_id: userId,
                                        f_name: fname,
                                        l_name: lname
                                    },
                                    url: 'database/delete-user.php',
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.success) {
                                            alert(response.message);
                                            window.location.reload();
                                        } else {
                                            alert(response.message);
                                        }
                                    }
                                })
                            } else {
                                console.log('Không xoá')
                            }
                        }

                    });
                }
        }
        var myScript = new script();
        myScript.initialize();
    </script>
    </div>
</body>

</html>