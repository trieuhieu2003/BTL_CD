<?php
session_start();

if (!isset($_SESSION['user']))
    header('location: login.php');
$_SESSION['table'] = 'users';
$user = $_SESSION['user'];

$show_table = 'users';

$users = include('database/show.php');

$user_permission = $user['permissions'];

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
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/css/bootstrap-dialog.min.css" integrity="sha512-PvZCtvQ6xGBLWHcXnyHD67NTP+a+bNrToMsIdX/NUqhw+npjLDhlMZ/PhSHZN4s9NdmuumcxKHQqbHlGVqc8ow==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div id="dashboardMainContainer">
        <?php include('partials/app_slidebar.php') ?>
        <div class="dashboard_content_container">
            <?php include('partials/app_topnav.php') ?>
            <div class="dashboard_content">
            <?php if(in_array('user_view',$user['permissions'])){?>

                <div class="dashboard_content_main">
                    <div class="row">
                        <div class="column column-12">
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
                                                    <td class="firstName"><?= $user['first_name'] ?></td>
                                                    <td class="LastName"><?= $user['last_name'] ?></td>
                                                    <td class="email"><?= $user['email'] ?></td>
                                                    <td><?= date('M d,Y @ h:i:s A', strtotime($user['created_at'])) ?></td>
                                                    <td><?= date('M d,Y @ h:i:s A', strtotime($user['updated_at'])) ?></td>

                                                    <td>
                                                        <a href="" class="<?= in_array('user_edit',$user_permission)? 'updateUser':'accessDeniedError' ?> " 
                                                        data-userid="<?= $user['id'] ?>"><i class="fa fa-pencil"></i>Sửa</a>
                                                        <a href="" class="<?= in_array('user_delete',$user_permission)? 'deleteUser':'accessDeniedError' ?> " 
                                                        data-userid="<?= $user['id'] ?>" data-fname="<?= $user['first_name'] ?>" data-lname="<?= $user['last_name'] ?>"><i class="fa fa-trash"></i>Xoá</a>
                                                        <input type="hidden" id="cur_permission_<?= $user['id'] ?>" value="<?= $user['permissions'] ?>">
                                                    </td>
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
    <script src="js/jquery/jquery-3.7.1.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/js/bootstrap-dialog.js" integrity="sha512-AZ+KX5NScHcQKWBfRXlCtb+ckjKYLO1i10faHLPXtGacz34rhXU8KM4t77XXG/Oy9961AeLqB/5o0KTJfy2WiA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function script() {
            this.permissions = [];
            
            this.permissionEl = '\
                <div class="permissions">\
                    <h4>Permissions</h4>\
                    <hr>\
                    <div id="permissionsContainer">\
                        <div class="permission">\
                            <div class="row">\
                                <div class="col-md-3">\
                                    <p class="moduleName">Dashboard</p>\
                                </div>\
                                <div class="col-md-2">\
                                    <p class="moduleFunc" data-value="dashboard_view">Xem</p>\
                                </div>\
                            </div>\
                        </div>\
                        <div class="permission">\
                            <div class="row">\
                                <div class="col-md-3">\
                                    <p class="moduleName">Báo cáo</p>\
                                </div>\
                                <div class="col-md-2">\
                                    <p class="moduleFunc" data-value="report_view">Xem</p>\
                                </div>\
                            </div>\
                        </div>\
                        <div class="permission">\
                            <div class="row">\
                                <div class="col-md-3">\
                                    <p class="moduleName">Đơn Hàng</p>\
                                </div>\
                                <div class="col-md-2">\
                                    <p class="moduleFunc" data-value="po_view">Xem</p>\
                                </div>\
                                <div class="col-md-2">\
                                    <p class="moduleFunc" data-value="po_create">Thêm</p>\
                                </div>\
                                <div class="col-md-2">\
                                    <p class="moduleFunc" data-value="po_edit">Sửa</p>\
                                </div>\
                            </div>\
                        </div>\
                        <div class="permission">\
                            <div class="row">\
                                <div class="col-md-3">\
                                    <p class="moduleName">Sản Phẩm</p>\
                                </div>\
                                <div class="col-md-2">\
                                    <p class="moduleFunc" data-value="product_view">Xem</p>\
                                </div>\
                                <div class="col-md-2">\
                                    <p class="moduleFunc" data-value="product_create">Thêm</p>\
                                </div>\
                                <div class="col-md-2">\
                                    <p class="moduleFunc" data-value="product_edit">Sửa</p>\
                                </div>\
                                <div class="col-md-2">\
                                    <p class="moduleFunc" data-value="product_delete">Xoá</p>\
                                </div>\
                            </div>\
                            <div class="permission">\
                                <div class="row">\
                                    <div class="col-md-3">\
                                        <p class="moduleName">Nhà Cung Cấp</p>\
                                    </div>\
                                    <div class="col-md-2">\
                                        <p class="moduleFunc" data-value="supplier_view">Xem</p>\
                                    </div>\
                                    <div class="col-md-2">\
                                        <p class="moduleFunc" data-value="supplier_create">Thêm</p>\
                                    </div>\
                                    <div class="col-md-2">\
                                        <p class="moduleFunc" data-value="supplier_edit">Sửa</p>\
                                    </div>\
                                    <div class="col-md-2">\
                                        <p class="moduleFunc" data-value="supplier_delete">Xoá</p>\
                                    </div>\
                                </div>\
                            </div>\
                            <div class="permission">\
                                <div class="row">\
                                    <div class="col-md-3">\
                                        <p class="moduleName">Người Dùng</p>\
                                    </div>\
                                    <div class="col-md-2">\
                                        <p class="moduleFunc" data-value="user_view">Xem</p>\
                                    </div>\
                                    <div class="col-md-2">\
                                        <p class="moduleFunc" data-value="user_create">Thêm</p>\
                                    </div>\
                                    <div class="col-md-2">\
                                        <p class="moduleFunc" data-value="user_edit">Sửa</p>\
                                    </div>\
                                    <div class="col-md-2">\
                                        <p class="moduleFunc" data-value="user_delete">Xoá</p>\
                                    </div>\
                                </div>\
                            </div>\
                            <div class="permission">\
                                <div class="row">\
                                    <div class="col-md-3">\
                                        <p class="moduleName">Điểm Bán</p>\
                                    </div>\
                                    <div class="col-md-2">\
                                        <p class="moduleFunc" data-value="pos">Trợ Cấp</p>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>\
                    </div>';

            this.initialize = function() {
                    this.registerEvents();
                },

                this.registerEvents = function() {
                    var self = this;
                    document.addEventListener('click', function(e) {
                        targetElement = e.target;
                        classList = targetElement.classList;
                        

                        if (classList.contains('accessDeniedError')) {
                        e.preventDefault();
                        BootstrapDialog.alert({
                            type: BootstrapDialog.TYPE_DANGER,
                            message: 'Không được cho phép'
                        });
                    }


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



                        if (classList.contains('deleteUser')) {

                            e.preventDefault();
                            userId = targetElement.dataset.userid;
                            fname = targetElement.dataset.fname;
                            lname = targetElement.dataset.lname;
                            fullName = fname + ' ' + lname;

                            if (window.confirm('Bạn có muốn xoá ' + fullName + ' không?')) {
                                $.ajax({
                                    method: 'POST',
                                    data: {
                                        user_id: userId,
                                        f_name: fname,
                                        l_name: lname
                                    },
                                    url: 'database/delete-user.php',
                                    dataType: 'json',
                                    success: function(data) {
                                        if (data.success) {
                                            if (window.confirm(data.message)) {
                                                location.reload();
                                            }
                                        } else window.alert(data.message);
                                    }
                                })

                            }
                        }

                        if (classList.contains('updateUser')) {
                            e.preventDefault();

                            // lấy dữ liệu 
                            firstName = targetElement.parentElement.parentElement.querySelector('td.firstName').innerHTML;
                            lastName = targetElement.parentElement.parentElement.querySelector('td.LastName').innerHTML;
                            email = targetElement.parentElement.parentElement.querySelector('td.email').innerHTML;
                            userId = targetElement.dataset.userid;
                            let permissions = document.getElementById('cur_permission_' + userId).value;
                            

                            BootstrapDialog.confirm({
                                title: 'Cập nhật người dùng ' + firstName + ' ' + lastName,
                                message: '<form>\
                                <div class="form-group">\
                                    <label for="first_Name">Họ:</label>\
                                    <input type="text" class="form-control" id="firstName" name="first_name" value="' + firstName + '">\</div>\
                                <div class="form-group">\ <label for="last_Name">Tên:</label>\
                                    <input type="text" class="form-control" id="lastName" name="last_name" value="' + lastName + '">\</div>\
                                <div class="form-group">\ <label for="email">Email:</label>\
                                    <input type="text" class="form-control" id="emailUpdate" name="email" value="' + email + '">\</div>' + self.permissionEl + '\
                                <input type="hidden" id="permission_el" name="permissions" value="'+ permissions + '" >\
                                </form>',
                                callback: function(isUpdate) {
                                    if (isUpdate) {                                                                                                                                     
                                        $.ajax({
                                            method: 'POST',
                                            data: {
                                                userId: userId,
                                                f_name: document.getElementById('firstName').value,
                                                l_name: document.getElementById('lastName').value,
                                                email: document.getElementById('emailUpdate').value,
                                                permissions: document.getElementById('permission_el').value
                                            },
                                            url: 'database/update-user.php',
                                            dataType: 'json',
                                            success: function(data) {
                                                if (data.success) {
                                                    BootstrapDialog.alert({
                                                        title: 'Thông báo',
                                                        type: BootstrapDialog.TYPE_SUCCESS,
                                                        message: data.message,
                                                        callback: function() {
                                                            location.reload();
                                                        }
                                                    });
                                                } else
                                                    BootstrapDialog.alert({
                                                        title: 'Thông báo',
                                                        type: BootstrapDialog.TYPE_DANGER,
                                                        message: data.message,

                                                    });
                                            }
                                        })
                                    }
                                },
                                onshown: function(){
                                    script.permissions = [];

                                    let permissionsArr = permissions.split(',');

                                    permissionsArr.forEach((permission)=>{
                                        if(permission !== ''){
                                            let targetEl = document.querySelector("[data-value='" + permission + "']");
                                            if(targetEl != null){
                                                targetEl.classList.add('permissionActive');
                                                script.permissions.push(permission);
                                            }
                                        }
                                    });
                                }
                            });
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