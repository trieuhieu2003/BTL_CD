<?php
session_start();

if (!isset($_SESSION['user']))
    header('location: login.php');

include('database/connection.php'); // Đảm bảo bạn đã có file này để kết nối CSDL

$show_table = 'suppliers';
$suppliers = include('database/show.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Order View - He Thong Quan Ly Kho</title>

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

                <?php if(in_array('po_view', $_SESSION['user']['permissions'])) { ?>
                    <div class="dashboard_content_main">
                        <div class="row">
                            <div class="column column-12">
                                <h1 class="section_header"><i class="fa fa-list"></i> Danh sách đơn hàng</h1>
                                <div class="section_content">
                                    <div class="poListContainers">
                                        <?php
                                        $stmt = $conn->prepare("
                                            SELECT order_product.id, products.product_name, order_product.quantity_ordered, users.first_name, order_product.batch,
                                            order_product.quantity_received,
                                            users.last_name, suppliers.supplier_name, order_product.status, order_product.created_at
                                            FROM order_product, suppliers, products, users
                                            WHERE 
                                                order_product.supplier = suppliers.id
                                                AND order_product.product = products.id
                                                AND order_product.created_by = users.id
                                            ORDER BY 
                                                order_product.created_at DESC
                                        ");
                                        $stmt->execute();
                                        $purchase_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        $data = [];
                                        foreach ($purchase_orders as $purchase_order) {
                                            $data[$purchase_order['batch']][] = $purchase_order;
                                        }
                                        ?>

                                        <?php foreach ($data as $batch_id => $batch_po) { ?>
                                            <div class="poList" id="container-<?= $batch_id ?>">
                                                <p>Batch #: <?= $batch_id ?> </p>
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Sản Phẩm</th>
                                                            <th>Số lượng đặt hàng</th>
                                                            <th>Thực Nhận</th>
                                                            <th>Nhà Cung Cấp</th>
                                                            <th>Trạng Thái</th>
                                                            <th>Đặt Bởi</th>
                                                            <th>Ngày Đặt</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $index = 1;
                                                        foreach ($batch_po as $po) { ?>
                                                            <tr>
                                                                <td><?= $index ?></td>
                                                                <td class="po_product"><?= $po['product_name'] ?></td>
                                                                <td class="po_qty_ordered"><?= $po['quantity_ordered'] ?></td>
                                                                <td class="po_qty_received"><?= $po['quantity_received'] ?></td>
                                                                <td class="po_qty_supplier"><?= $po['supplier_name'] ?></td>
                                                                <td class="po_qty_status">
                                                                    <span class="po-badge po-badge-<?= $po['status'] ?>">
                                                                        <?= $po['status'] ?>
                                                                    </span>
                                                                </td>
                                                                <td><?= $po['first_name'] . ' ' . $po['last_name'] ?></td>
                                                                <td>
                                                                    <?= $po['created_at'] ?>
                                                                    <input type="hidden" class="po_qty_row_id" value="<?= $po['id'] ?>">
                                                                </td>
                                                            </tr>
                                                        <?php $index++; } ?>
                                                    </tbody>
                                                </table>
                                                <?php if(in_array('po_edit', $_SESSION['user']['permissions'])){ ?>
                                                    <div class="poOrderUpdateBtnContainer alignRight">
                                                        <button class="appbtn updatePoBtn" data-id="<?= $batch_id ?>">Cập Nhật</button>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
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

    <script src="js/script.js"></script>
    <script>

        function Script() {
            var vm = this;

            this.registerEvents = function () {
                document.addEventListener('click', function (e) {
                    var targetElement = e.target;
                    var classList = targetElement.classList;

                    if (classList.contains('updatePoBtn')) {
                        e.preventDefault();

                        var batchNumber = targetElement.dataset.id;
                        var batchNumberContainer = 'container-' + batchNumber;

                        // Get all purchase order product records
                        var productList = document.querySelectorAll('#' + batchNumberContainer + ' .po_product');
                        var qtyOrderedList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_ordered');
                        var qtyReceivedList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_received');
                        var supplierList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_supplier');
                        var statusList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_status');
                        var rowIds = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_row_id');

                        var poListsArr = [];
                        for (var i = 0; i < productList.length; i++) {
                            poListsArr.push({
                                name: productList[i].innerText,
                                qtyOrdered: qtyOrderedList[i].innerText,
                                qtyReceived: qtyReceivedList[i].innerText,
                                supplier: supplierList[i].innerText,
                                status: statusList[i].innerText,
                                id: rowIds[i].value
                            });
                        }

                        var poListHtml = '\
                    <table id="formTable_'+ batchNumber + '">\
                        <thead>\
                        <tr>\
                            <th>Tên Sản Phẩm</th>\
                            <th>Số lượng đặt hàng</th>\
                            <th>Thực Nhận</th>\
                            <th>Nhà Cung Cấp</th>\
                            <th>Trạng Thái</th>\
                            <th>Thao Tác</th>\
                        </tr>\
                        </thead>\
                        <tbody>';

                        poListsArr.forEach((poList) => {
                            poListHtml += '\
                    <tr>\
                        <td class="po_product alignLeft">' + poList.name + '</td>\
                        <td class="po_qty_ordered">' + poList.qtyOrdered + '</td>\
                        <td class="po_qty_received"><input type="number" value="' + poList.qtyReceived + '" /></td>\
                        <td class="po_qty_supplier alignLeft">' + poList.supplier + '</td>\
                        <td>\
                            <select class="po_qty_status">\
                                <option value="pending" ' + (poList.status == 'pending' ? 'selected' : '') + '>Chưa hoàn thành</option>\
                                <option value="incomplete" ' + (poList.status == 'incomplete' ? 'selected' : '') + '>Chưa đủ</option>\
                                <option value="complete" ' + (poList.status == 'complete' ? 'selected' : '') + '>Hoàn thành</option>\
                            </select>\
                            <input type="hidden" class="po_qty_row_id" value="'+ poList.id + '">\
                        </td>\
                    </tr>\
                    ';
                        });

                        poListHtml += '</tbody></table>';

                        BootstrapDialog.confirm({
                            type: BootstrapDialog.TYPE_PRIMARY,
                            title: 'Cập Nhật Đơn Hàng: Batch #: <strong>' + batchNumber + '</strong>',
                            message: poListHtml,
                            callback: function (toAdd) {
                                // Nếu xác nhận
                                if (toAdd) {
                                    var formTableContainer = 'formTable_' + batchNumber;

                                    var qtyReceivedList = document.querySelectorAll('#' + formTableContainer + ' .po_qty_received input');
                                    var statusList = document.querySelectorAll('#' + formTableContainer + ' .po_qty_status');
                                    var rowIds = document.querySelectorAll('#' + formTableContainer + ' .po_qty_row_id');
                                    var qtyOrdered = document.querySelectorAll('#' + formTableContainer + ' .po_qty_ordered');

                                    var poListsArrForm = [];
                                    for (var i = 0; i < qtyReceivedList.length; i++) {
                                        poListsArrForm.push({
                                            qtyReceived: qtyReceivedList[i].value,
                                            status: statusList[i].value,
                                            id: rowIds[i].value,
                                            qtyOrdered: qtyOrdered[i].innerText
                                        });
                                    }

                                    $.ajax({
                                        method: 'POST',
                                        data: JSON.stringify({ payload: poListsArrForm }), // Chuyển đổi thành JSON string
                                        url: 'database/update-order.php',
                                        contentType: 'application/json', // Thêm content type
                                        dataType: 'json',
                                        success: function (data) {
                                            BootstrapDialog.alert({
                                                type: data.success
                                                    ? BootstrapDialog.TYPE_SUCCESS
                                                    : BootstrapDialog.TYPE_DANGER,
                                                message: data.message,
                                                callback: function () {
                                                    if (data.success) location.reload();
                                                }
                                            });
                                        },
                                        error: function (xhr, status, error) {
                                            BootstrapDialog.alert({
                                                type: BootstrapDialog.TYPE_DANGER,
                                                message: 'Có lỗi xảy ra: ' + JSON.stringify(xhr.responseText)
                                            });
                                        }
                                    });
                                }
                            }
                        });
                    }
                });
            };

            this.initialize = function () {
                this.registerEvents();
            };
        }

        var myScript = new Script();
        myScript.initialize();

        var myScript = new Script();
        myScript.initialize();

        var myScript = new Script(); // Tạo một đối tượng từ constructor
        myScript.initialize(); // Gọi phương thức từ đối tượng
    </script>
</body>

</html>