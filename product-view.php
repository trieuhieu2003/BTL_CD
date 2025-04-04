<?php
session_start();

if (!isset($_SESSION['user']))
    header('location: login.php');


$show_table = 'products';
$products = include('database/show.php');


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product View - He Thong Quan Ly Kho</title>

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
            <?php if(in_array('product_view',$user['permissions'])){?>
                <div class="dashboard_content_main">
                    <div class="row">
                        <div class="column column-12">
                            <h1 class="section_header"><i class="fa fa-list"></i> Danh sách sản phẩm</h1>
                            <div class="section_content">
                                <div class="users">

                                    <table>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Ảnh</th>
                                                <th>Tên sản phẩm</th>
                                                <th>Đơn hàng</th>
                                                <th>Mô tả</th>
                                                <th>Nhà cung cấp </th>
                                                <th>Tạo bởi</th>
                                                <th>Ngày tạo</th>
                                                <th>Ngày cập nhật</th>
                                                <th>Hoạt động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($products as $index => $product) { ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td class="firstName">
                                                        <img class="productImages" src="uploads/products/<?= $product['img'] ?>" alt="" />
                                                    </td>
                                                    <td class="LastName"><?= $product['product_name'] ?></td>
                                                    <td class="LastName"><?= number_format($product['stock']) ?></td>
                                                    <td class="email"><?= $product['description'] ?></td>
                                                    <td class="email">
                                                        <?php
                                                        $supplier_list = '-';

                                                        $pid = $product['id'];
                                                        $stmt = $conn->prepare("SELECT supplier_name FROM suppliers, productsuppliers WHERE productsuppliers.product=$pid AND productsuppliers.supplier=suppliers.id");
                                                        $stmt->execute();
                                                        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                        if ($row) {

                                                            $supplier_arr = array_column($row, "supplier_name");
                                                            $supplier_list = '<li>' . implode(',', $supplier_arr);
                                                        }
                                                        echo $supplier_list;

                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $uid = $product['created_by'];
                                                        $stmt = $conn->prepare("SELECT * FROM users WHERE id=$uid");
                                                        $stmt->execute();
                                                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                                        $created_by_name = $row['first_name'] . ' ' . $row['last_name'];
                                                        echo $created_by_name;
                                                        ?>


                                                    </td>
                                                    <td><?= date('M d,Y @ h:i:s A', strtotime($product['created_at'])) ?></td>
                                                    <td><?= date('M d,Y @ h:i:s A', strtotime($product['updated_at'])) ?></td>

                                                    <td>
                                                        <a href="" class="updateProduct" data-pid="<?= $product['id'] ?>" data-pid="<?= $product['description'] ?>"><i class="fa fa-pencil"></i>Sửa</a>
                                                        <a href="" class="deleteProduct" data-name="<?= $product['product_name'] ?>" data-pid="<?= $product['id'] ?>"><i class="fa fa-trash"></i>Xoá</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                    <p class="userCount"><?= count($products) ?> Sản phẩm</p>
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

    </div>
    

    <?php
    include('partials/app-scripts.php');

    $show_table = 'suppliers';
    $suppliers = include('database/show.php');

    $supplier_arr = [];

    foreach ($suppliers as $supplier) {
        $supplier_arr[$supplier['id']] = $supplier['supplier_name'];
    }
    $supplier_arr = json_encode($supplier_arr);
    ?>

    <script src="js/script.js"></script>
    
    <script>
        var suppliersList = <?= $supplier_arr ?>;

        function Script() { // Đặt tên hàm với chữ cái đầu in hoa (theo quy tắc PascalCase)
            var vm = this; // Đặt tên biến vm (viết tắt của ViewModel)

            this.registerEvents = function() {

                document.addEventListener('click', function(e) {
                    targetElement = e.target; 
                    classList = targetElement.classList;


                    if (classList.contains('deleteProduct')) {

                        e.preventDefault();
                        pId = targetElement.dataset.pid;
                        pName = targetElement.dataset.name;




                        if (window.confirm('Bạn có muốn xoá ' + pName + ' không?')) {

                            $.ajax({
                                method: 'POST',
                                data: {
                                    id: pId,
                                    table: 'products'
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
                    if (classList.contains('accessDeniedError')) {
                        e.preventDefault();
                        BootstrapDialog.alert({
                            type: BootstrapDialog.TYPE_DANGER,
                            message: 'Không được cho phép'
                        });
                    }

                    if (classList.contains('updateProduct')) {
                        e.preventDefault();

                        pId = targetElement.dataset.pid;
                        vm.showEditDialog(pId);

                    }
                });

                document.addEventListener('submit', function(e) {
                    e.preventDefault();
                    targetElement = e.target; 

                    if (targetElement.id === 'editProductForm') {
                        vm.saveUpdateData(targetElement);
                    }

                });
            }

            this.saveUpdateData = function(form) {
                $.ajax({
                    method: 'POST',
                    data: new FormData(form),
                    url: 'database/update-product.php',

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

                $.get('database/get-product.php', {
                    id: id
                }, function(productDetails) {
                    let curSuppliers = productDetails['suppliers'];
                    let supplierOption = '';

                    for (const [supId, supName] of Object.entries(suppliersList)) {
                        selected = curSuppliers.indexOf(supId) > -1 ? 'selected' : '';
                        supplierOption += "<option " + selected + " value='" + supId + "'>" + supName + "</option>";
                    }

                    BootstrapDialog.confirm({
                        title: 'Cập nhật <strong> ' + productDetails.product_name + '</strong>',
                        message: '<form action="database/add.php" method="POST" enctype="multipart/form-data" id="editProductForm">\
                            <div class="appFormInputContainer">\
                                        <label for="product_name">Tên sản phẩm</label>\
                                        <input type="text" class="appFormInput" id="product_name" value="' + productDetails.product_name + '" placeholder=" Nhập tên sản phẩm..." name="product_name">\
                                    </div>\
                                    <div class="appFormInputContainer">\
                                        <label for="description">Nhà cung cấp</label>\
                                        <select name="suppliers[]" id="suppliersSelect" multiple="">\
                                            <option value="">Chọn nhà cung cấp</option>\
                                            ' + supplierOption + '\
                                        </select>\
                                    </div>\
                                    <div class="appFormInputContainer">\
                                        <label for="description">Mô tả</label>\
                                        <textarea class="appFormInput productTextAreaInput" value="" placeholder=" Mô tả sản phẩm..." name="description" id="description">' + productDetails.description + '</textarea>\
                                    </div>\
                                    <div class="appFormInputContainer">\
                                        <label for="product_name">Ảnh</label>\
                                        <input type="file" name="img" />\
                                    </div>\
                                    <input type="hidden" name="pid" value="' + productDetails.id + '"/>\
                                    <input type="submit" value="submit" id="editProductSubmitBtn" class="hidden"/>\
                                    </form>\
                        ',
                        callback: function(isUpdate) {

                            if (isUpdate) {

                                document.getElementById('editProductSubmitBtn').click();
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