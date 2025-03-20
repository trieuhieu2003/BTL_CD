<?php
session_start();

if (!isset($_SESSION['user']))
    header('location: login.php');
$show_table = 'suppliers';

$suppliers = include('database/show.php');


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Supplier View - He Thong Quan Ly Kho</title>

    <link rel="stylesheet" href="css/user_add.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"
        integrity="sha512-b+nQTCdtTBIRIbraqNEwsjB6UvL3UEMkXnhzd8awtCYh0Kcsjl9uEgwVFVbhoj3uu1DO1ZMacNvLoyJJiNfcvg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
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
                            <h1 class="section_header"><i class="fa fa-list"></i> Danh sách nhà cung cấp</h1>
                            <div class="section_content">
                                <div class="users">

                                    <table>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tên nhà cung cấp</th>
                                                <th>Địa chỉ nhà cung cấp</th>
                                                <th>Chi tiết liên hệ</th>
                                                <th>Sản phẩm</th>
                                                <th>Tạo bởi</th>
                                                <th>Ngày tạo</th>
                                                <th>Ngày cập nhật</th>
                                                <th>Hoạt động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($suppliers as $index => $supplier) { ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td><?= $supplier['supplier_name'] ?></td>


                                                    <td><?= $supplier['supplier_location'] ?></td>
                                                    <td><?= $supplier['email'] ?></td>
                                                    <td>
                                                        <?php
                                                        $product_list = '-';

                                                        $sid = $supplier['id'];
                                                        $stmt = $conn->prepare("SELECT product_name FROM products, productsuppliers WHERE productsuppliers.supplier=$sid AND productsuppliers.product=products.id");
                                                        $stmt->execute();
                                                        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                        if ($row) {

                                                            $product_arr = array_column($row, "product_name");
                                                            $product_list = '<li>' . implode(',', $product_arr);
                                                        }
                                                        echo $product_list;

                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $uid = $supplier['created_by'];
                                                        $stmt = $conn->prepare("SELECT * FROM users WHERE id=$uid");
                                                        $stmt->execute();
                                                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                                        $created_by_name = $row['first_name'] . ' ' . $row['last_name'];
                                                        echo $created_by_name;
                                                        ?>
                                                    </td>
                                                    <td><?= date('M d,Y @ h:i:s A', strtotime($supplier['created_at'])) ?></td>
                                                    <td><?= date('M d,Y @ h:i:s A', strtotime($supplier['updated_at'])) ?></td>

                                                    <td>
                                                        <a href="" class="updateSupplier" data-sid="<?= $supplier['id'] ?>"><i class="fa fa-pencil"></i>Sửa</a>
                                                        <a href="" class="deleteSupplier" data-name="<?= $supplier['supplier_name'] ?>" data-sid="<?= $supplier['id'] ?>"><i class="fa fa-trash"></i>Xoá</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                    <p class="userCount"><?= count($suppliers) ?> Nhà cung cấp</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php
    include('partials/app-scripts.php');

    $show_table = 'products';
    $products = include('database/show.php');

    $product_arr = [];

    foreach ($products as $product) {
        $product_arr[$product['id']] = $product['product_name'];
    }
    $product_arr = json_encode($product_arr);
    ?>

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

    <script>
    </script>
    <script>
        var productsList = <?= $product_arr ?>;

        function Script() { // Đặt tên hàm với chữ cái đầu in hoa (theo quy tắc PascalCase)
            var vm = this; // Đặt tên biến vm (viết tắt của ViewModel)

            this.registerEvents = function() {

                document.addEventListener('click', function(e) {
                    targetElement = e.target; //target element is the element that triggered the event
                    classList = targetElement.classList;



                    if (classList.contains('deleteSupplier')) {

                        e.preventDefault();
                        sId = targetElement.dataset.sid;
                        supplierName = targetElement.dataset.name;




                        if (window.confirm('Bạn có muốn xoá ' + supplierName + ' không?')) {

                            $.ajax({
                                method: 'POST',
                                data: {
                                    id: sId,
                                    table: 'suppliers'
                                },
                                url: 'database/delete.php',
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

                    if (classList.contains('updateSupplier')) {
                        e.preventDefault();

                        sId = targetElement.dataset.sid;


                        vm.showEditDialog(sId);




                    }
                });

                document.addEventListener('submit', function(e) {
                    e.preventDefault();
                    targetElement = e.target; //target element is the element that triggered the event

                    if (targetElement.id === 'editSupplierForm') {
                        vm.saveUpdateData(targetElement);
                    }

                });
            }

            this.saveUpdateData = function(form) {
                $.ajax({
                    method: 'POST',
                    data: new FormData(form),
                    url: 'database/update-supplier.php',

                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(data) {
                        BootstrapDialog.alert({
                            type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
                            message: data.message,
                            callback: function() {
                                if (data.success) location.reload();
                            }
                        })
                    }
                })
            }

            this.showEditDialog = function(id) {

                $.get('database/get-supplier.php', {
                    id: id
                }, function(supplierDetails) {
                    let curProducts = supplierDetails['products'] || [];
                    let productOption = '';

                    for (const [pId, pName] of Object.entries(productsList)) {
                        selected = curProducts.indexOf(pId) > -1 ? 'selected' : '';
                        productOption += "<option " + selected + " value='" + pId + "'>" + pName + "</option>";
                    }

                    BootstrapDialog.confirm({
                        title: 'Cập nhật <strong> ' + supplierDetails.supplier_name + '</strong>',
                        message: '<form action="database/add.php" method="POST" enctype="multipart/form-data" id="editSupplierForm">\
                            <div class="appFormInputContainer">\
                                        <label for="supplier_name">Tên nhà cung cấp</label>\
                                        <input type="text" class="appFormInput" id="supplier_name" value="' + supplierDetails.supplier_name + '" placeholder="Nhập tên nhà cung cấp..." name="supplier_name">\
                                    </div>\
                                    <div class="appFormInputContainer">\
                                        <label for="supplier_location">Địa chỉ</label>\
                                        <input type="text" class="appFormInput productTextAreaInput" value="' + supplierDetails.supplier_location + '" placeholder="Nhập địa chỉ nhà cung cấp..." name="supplier_location" id="supplier_location"></input>\
                                    </div>\
                                    <div class="appFormInputContainer">\
                                        <label for="email">Email</label>\
                                        <input type="text" class="appFormInput productTextAreaInput" value="' + supplierDetails.email + '" placeholder=" Nhập email nhà cung cấp..." name="email" id="email"></input>\
                                    </div>\
                                    <div class="appFormInputContainer">\
                                        <label for="products">Products</label>\
                                        <select name="products[]" id="products" multiple="">\
                                            <option value="">Chọn nhà cung cấp</option>\
                                            ' + productOption + '\
                                        </select>\
                                    </div>\
                                    <input type="hidden" name="sid" value="' + supplierDetails.id + '"/>\
                                    <input type="submit" value="submit" id="editSupplierSubmitBtn" class="hidden"/>\
                                    </form>\
                        ',
                        callback: function(isUpdate) {

                            if (isUpdate) {

                                document.getElementById('editSupplierSubmitBtn').click();



                            }
                        }

                    });

                }, 'json');


            }

            this.initialize = function() {
                this.registerEvents();

            }
        }

        var myScript = new Script(); // Tạo một đối tượng từ constructor
        myScript.initialize(); // Gọi phương thức từ đối tượng
    </script>
</body>

</html>