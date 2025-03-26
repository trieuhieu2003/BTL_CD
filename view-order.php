<?php
session_start();

if (!isset($_SESSION['user']))
    header('location: login.php');
$_SESSION['table'] = 'users';

$_SESSION['table'] = 'users';

$users = include('database/show.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Đơn Hàng - He Thong Quan Ly Kho</title>

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
                            <h1 class="section_header"><i class="fa fa-list"></i> Quản Lý Đơn Hàng</h1>
                            <div class="section_content">
                                <div class="poListContainers">
                                    <?php
                                    $stmt = $conn->prepare("
                                            SELECT products.product_name, order_product.quantity_ordered, users.first_name, users.last_name, order_product.batch, suppliers.supplier_name, order_product.status, order_product.created_at
                                                FROM order_product, suppliers, products, users
                                                WHERE 
                                                    order_product.supplier = suppliers.id
                                                        AND
                                                    order_product.product = products.id
                                                        AND
                                                    order_product.created_by = users.id                 
                                                ORDER BY
                                                    order_product.created_at DESC
                                            ");
                                            
                                    $stmt->execute();
                                    $purchase_orders = $stmt->fetch(PDO::FETCH_ASSOC);

                                    $data = [];
                                    foreach ($purchase_orders as $purchase_order) {
                                        $data[$purchase_order['batch']][] = $purchase_order;
                                    }
                                    ?>

                                    <?php
                                        foreach ($data as $batch_id => $batch_pos) {
                                    ?>
                                    <div class="poList">
                                        <>Batch #:<?= $batch_id?></p>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Sản Phẩm</th>
                                                    <th>Số Lượng</th>
                                                    <th>Nhà Cung Cấp</th>
                                                    <th>Trạng Thái</th>
                                                    <th>Tạo Bởi</th>
                                                    <th>Thời Gian</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach ($batch_pos as $index => $batch_pos) {
                                                ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td><?=$batch_pos['product_name'] ?></td>
                                                    <td><?=$batch_pos['quantity_ordered'] ?></td>
                                                    <td><?=$batch_pos['supplier_name'] ?></td>
                                                    <td><span class="po-badge po-badge-<?= $batch_po['status'] ?>"><?= $batch_po['status'] ?></span></td>
                                                    <td><?=$batch_pos['first_name'] ?></td>
                                                    <td><?=$batch_pos['created_at'] ?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <div class="poOrderUpdateBtnContainer alignRight">
                                            <button class="appBtn updatePoBtn">Cập Nhật</button>
                                        </div>
                                    </div>
                                    <?php 
                                        }
                                    ?>
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
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
        integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/js/bootstrap-dialog.js"
        integrity="sha512-AZ+KX5NScHcQKWBfRXlCtb+ckjKYLO1i10faHLPXtGacz34rhXU8KM4t77XXG/Oy9961AeLqB/5o0KTJfy2WiA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <?php include('partials/app-scripts.php'); ?>

    <script>
        function script() {

            this.initialize = function () {
                this.registerEvents();
            },

                this.registerEvents = function () {
                    document.addEventListener('click', function (e) {
                        targetElement = e.target;
                        classList = targetElement.classList;

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
                                    success: function (data) {
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

                            BootstrapDialog.confirm({
                                title: 'Cập nhật người dùng ' + firstName + ' ' + lastName,
                                message: '<form>\
                                <div class="form-group">\
                                    <label for="first_Name">Họ:</label>\
                                    <input type="text" class="form-control" id="firstName" name="first_name" value="' + firstName + '">\</div>\
                                <div class="form-group">\ <label for="last_Name">Tên:</label>\
                                    <input type="text" class="form-control" id="lastName" name="last_name" value="' + lastName + '">\</div>\
                                <div class="form-group">\ <label for="email">Email:</label>\
                                    <input type="text" class="form-control" id="emailUpdate" name="email" value="' + email + '">\</div>\
                                </form>',
                                callback: function (isUpdate) {

                                    if (isUpdate) {
                                        $.ajax({
                                            method: 'POST',
                                            data: {
                                                userId: userId,
                                                f_name: document.getElementById('firstName').value,
                                                l_name: document.getElementById('lastName').value,
                                                email: document.getElementById('emailUpdate').value
                                            },
                                            url: 'database/update-user.php',
                                            dataType: 'json',
                                            success: function (data) {
                                                if (data.success) {
                                                    BootstrapDialog.alert({
                                                        title: 'Thông báo',
                                                        type: BootstrapDialog.TYPE_SUCCESS,
                                                        message: data.message,
                                                        callback: function () {
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
                                }

                            });
                        }
                    });
                }
        }
        var myScript = new script();
        myScript.initialize();
    </script>

</body>

</html>