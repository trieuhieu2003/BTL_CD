<?php
    session_start();
    if (isset($_SESSION['user'])) header('location: login.php');
        $_SESSION['table'] = 'users';
        $user = $_SESSION['user'];
        $users = include('database/show-users.php');
        var_dump($users);
        die;
?>

<!DOCTYPE html>
<html lang="en">    
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bảng điều khiển - Hệ thống quản lý hàng tồn kho</title>
        <link rel="stylesheet" href="css/login.css" type=" text/css">
        <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
    </head>
    <body>
        <div id="dashboardMainContainer">
            <?php include 'partials/app-sidebar.php'; ?>
            <div class="dashboard_content_container" id="dashboard_content_container">
                <?php include('partials/app-topnav.php') ?>
                <div class="dashboard_content">
                    <div class="dashboard_content-main">
                        <div class="row">
                            <div class="column-5">
                                <h1 class="section_header"><i class="fa fa-plus"></i>Create User</h1>
                                <div id="userAddFormContainer">
                                    <form action="database/add.php" method="POST" class="appForm">
                                        <div class="appFormInputContainer">
                                            <label for="first_name" >Họ</label>
                                            <input type="text" name="first_name" id="first_name" class="appFormInput" required>
                                        </div>
                                        <div class="appFormInputContainer">
                                            <label for="last_name" >Tên</label>
                                            <input type="text" name="last_name" id="last_name" class="appFormInput" required>
                                        </div>
                                        <div class="appFormInputContainer">
                                            <label for="email" >Email</label>
                                            <input type="text" name="email" id="email" class="appFormInput" required>
                                        </div> 
                                        <div class="appFormInputContainer">
                                            <label for="password" >Mật khẩu</label>
                                            <input type="password" name="password" id="password" class="appFormInput" required>
                                        </div>    
                                        <button class="appBtn" type="submit"><i class="fa fa-plus"></i>Add User</button>
                                    </form>
                                    <?php if (isset($_SESSION['response'])) {
                                        $response_message = $_SESSION['response']['message'];
                                        $is_success = $_SESSION['response']['success'];
                                    ?>
                                        <div class="responseMessage">
                                            <p class="responseMessage <?= $is_success ? 'responseMessage__success' : 'responseMessage__error' ?>">
                                                <?= $response_message ?>
                                            </p>
                                        </div>
                                    <?php unset($_SESSION['response']); } ?>
                                </div>
                            </div>
                            <div class="column-7">
                                <h1 class="section_header"><i class="fa fa-list"></i> List of Users</h1>
                                <div class="section_content">
                                    <div class="users">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th> # </th>
                                                    <th> First Name </th>
                                                    <th> Last Name </th>
                                                    <th> Email </th>
                                                    <th> Created At </th>
                                                    <th> Updated At </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($users as $index => $user){ ?>
                                                    <tr>
                                                        <td><?= $index + 1 ?></td>
                                                        <td><?= $user['first name'] ?></td>
                                                        <td><?= $user['last_name'] ?></td>
                                                        <td><?= $user['email'] ?></td>
                                                        <td><?= date('M d, Y @ h:i:s A', strtotime($user['created_at'])) ?></td>
                                                        <td><?= date('M d, Y @ h:i:s A', strtotime($user['updated_at'])) ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <p class="userCount"><?= count($users)  ?>Users</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>     
            </div>
        </div>

        <script src="js/app.js"></script>
    </body>
</html>