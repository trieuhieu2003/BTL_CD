<?php
// Bắt đầu phiên làm việc
session_start();
if (!isset($_SESSION['user'])) {
    header('location: login.php');
    exit();
}

$show_table = 'products';
$products = include('database/show.php');
$products = json_encode($products ?? []);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Order Product - He Thong Quan Ly Kho</title>

    <link rel="stylesheet" href="css/user_add.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/product-add.css">
    <link rel="stylesheet" href="css/order-product.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/css/bootstrap-dialog.min.css"
        integrity="sha512-PvZCtvQ6xGBLWHcXnyHD67NTP+a+bNrToMsIdX/NUqhw+npjLDhlMZ/PhSHZN4s9NdmuumcxKHQqbHlGVqc8ow=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div id="dashboardMainContainer">
        <?php include('partials/app_slidebar.php'); ?>
        <div class="dashboard_content_container">
            <?php include('partials/app_topnav.php'); ?>
            <div class="dashboard_content">
                <?php
                if (in_array('po_create', $user['permissions'])) { ?>
                    <div class="dashboard_content_main">
                        <div class="row">
                            <div class="column column-12">
                                <h1 class="section_header"><i class="fa fa-plus"></i> Đơn Hàng</h1>
                                <div>
                                    <form action="database/save-order.php" method="POST">
                                        <div class="alignRight">
                                            <button type="button" class="orderBtn orderProductBtn" id="orderProductBtn">
                                                Đặt Hàng Sản Phẩm </button>
                                        </div>
                                        <div id="orderProductLists">

                                            <div id="orderProductLists">
                                                <p id="noData" style="color: #9f9f9f;">Không có sản phẩm nào được chọn</p>
                                            </div>
                                        </div>
                                        <div class="alignRight marginTop20">
                                            <button type="submit" class="orderBtn submitOrderProductBtn">Xác Nhận</button>
                                        </div>
                                    </form>
                                </div>
                                <?php
                                if (isset($_SESSION['response'])) {
                                    $response_message = $_SESSION['response']['message'];
                                    $is_success = $_SESSION['response']['success'];
                                ?>

                                    <div class="responseMessage">
                                        <p
                                            class="responseMessage <?= $is_success ? 'responseMessage__success' : 'responseMessage__error' ?>">
                                            <?= $response_message ?>
                                        </p>
                                    </div>

                                <?php unset($_SESSION['response']);
                                } ?>

                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div id="errorMessage">
                        Không được cho phép
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php include('partials/app-scripts.php'); ?>

    <script>
        var products = <?= $products ?>;
        var counter = 0;

        function script() {
            var vm = this;

            let productOptions = '\
                <div>\
                    <label for="product_name">Tên sản phẩm</label>\
                    <select name="products_name[]" class="productNameSelect" id="product_name">\
                        <option value="">Chọn Sản Phẩm</options>\
                        INSERTPRODUCTHERE\
                    </select>\
                    <button class="appbtn removeOrderBtn">Loại Bỏ</button>\
                </div>';

            this.initialize = function() {
                this.registerEvents();
                this.renderProductOptions();
            };

            this.renderProductOptions = function() {
                    let optionHtml = '';
                    products.forEach((product) => {
                        optionHtml += '<option value="' + product.id + '">' + product.product_name + '</option>';
                    })

                    productOptions = productOptions.replace('INSERTPRODUCTHERE', optionHtml);
                },

                this.registerEvents = function() {
                    document.addEventListener('click', function(e) {
                        let targetElement = e.target;
                        classList = targetElement.classList;

                        if (targetElement.id === 'orderProductBtn') {
                            document.getElementById('noData').style.display = 'none';
                            let orderProductListsContainer = document.getElementById('orderProductLists');
                            orderProductListsContainer.innerHTML = '';

                            orderProductLists.innerHTML += '\
                                <div class="orderProductRow">\
                                    ' + productOptions + '\
                                    <div class="supplierRows" id="supplierRows_' + counter + '" data-counter="' + counter + '"></div>\
                                </div>';

                            counter++;
                        }

                        if (targetElement.classList.contains('removeOrderBtn')) {
                            let orderRow = targetElement.closest('div.orderProductRow');

                            orderRow.remove();
                            console.log(orderRow);
                        }

                        // if (targetElement.classList.contains('submitOrderProductBtn')) {
                        //     // Xử lý gửi đơn hàng
                        //     console.log('Submitting order...');
                        //     // Thêm code xử lý form submit tại đây
                        // }
                    });

                    document.addEventListener('change', function(e) {
                        targetElement = e.target;
                        classList = targetElement.classList;

                        if (classList.contains('productNameSelect')) {
                            let pid = targetElement.value;

                            let counterId = targetElement
                                .closest('div.orderProductRow')
                                .querySelector('.supplierRows')
                                .dataset.counter;


                            $.get('database/get-product-suppliers.php', {
                                id: pid
                            }, function(suppliers) {
                                vm.renderSupplierRows(suppliers, counterId);
                            }, 'json');
                        }
                    });
                };

            this.renderSupplierRows = function(suppliers, counterId) {
                let supplierRows = '';

                suppliers.forEach((supplier) => {
                    supplierRows = '\
                        <div class="row">\
                            <div style="width: 50%;">\
                                <p class="supplierName">' + supplier.supplier_name + '</p>\
                            </div>\
                            <div style="width: 50%;">\
                                <label for="quantity">Số lượng: </label>\
                                <input type="number" class="appFormInput orderProductQty" id="quantity"\
                                    placeholder="Nhập số lượng..." name="quantity[' + counterId + '][' + supplier.id + ']" />\
                            </div>\
                        </div>';
                });

                let supplierRowsContainer = document.getElementById('supplierRows_' + counterId);
                supplierRowsContainer.innerHTML = supplierRows;
            };
        }

        (new script()).initialize();
    </script>
</body>

</html>