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
    <title> Order View - He Thong Quan Ly Kho</title>

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
                            <h1 class="section_header"><i class="fa fa-list"></i> Danh sách đơn hàng</h1>
                            <div class="section_content">
                                <div class="poListContainers">
                                    <?php
                                    $stmt = $conn->prepare("
                                        SELECT order_product.id, order_product.product, products.product_name, order_product.quantity_ordered, users.first_name, order_product.batch,
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

                                    $data = [];
                                    foreach ($purchase_orders as $purchase_order) {
                                        $data[$purchase_order['batch']][] = $purchase_order;
                                    }
                                    ?>

                                    <?php
                                    foreach ($data as $batch_id => $batch_po) {

                                        ?>



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
                                                        <th>Lịch sử giao hàng</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $index = 1;
                                                    foreach ($batch_po as $batch_po) {
                                                        ?>
                                                        <tr>
                                                            <td><?= $index ?></td>
                                                            <td class="po_product"><?= $batch_po['product_name'] ?></td>
                                                            <td class="po_qty_ordered"><?= $batch_po['quantity_ordered'] ?></td>
                                                            <td class="po_qty_received"><?= $batch_po['quantity_received'] ?>
                                                            </td>
                                                            <td class="po_qty_supplier"><?= $batch_po['supplier_name'] ?></td>
                                                            <td class="po_qty_status">
                                                                <span class="po-badge po-badge-<?= $batch_po['status'] ?>">
                                                                    <?= $batch_po['status'] ?>
                                                                </span>
                                                            </td>
                                                            <td><?= $batch_po['first_name'] . ' ' . $batch_po['last_name'] ?>
                                                            </td>
                                                            <td>
                                                                <?= $batch_po['created_at'] ?>
                                                                <input type="hidden" class="po_qty_row_id" value="<?= $batch_po['id'] ?>">
                                                                <input type="hidden" class="po_qty_productid" value="<?= $batch_po['id'] ?>">
                                                            </td>
                                                            <td>
                                                                <button class="appBtn appDeliveryHistory" data-id="<?= $batch_po['id']?>"> Lịch sử giao hàng </button>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $index++;
                                                    } ?>
                                                </tbody>
                                            </table>
                                            <div class="poOrderUpdateBtnContainer alignRight">
                                                <button class="appbtn updatePoBtn" data-id="<?= $batch_id ?>">Cập Nhật</button>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                        var pIds = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_productid');

                        var poListsArr = [];
                        for (var i = 0; i < productList.length; i++) {
                            poListsArr.push({
                                name: productList[i].innerText,
                                qtyOrdered: qtyOrderedList[i].innerText,
                                qtyReceived: qtyReceivedList[i].innerText,
                                supplier: supplierList[i].innerText,
                                status: statusList[i].innerText,
                                id: rowIds[i].value,
                                pid: pIds[i].value,
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
                        <td class="po_qty_received">' + poList.qtyReceived + '</td>\
                        <td class="po_qty_delivered"><input type="number" value="' + poList.qtyReceived + '" /></td>\
                        <td class="po_qty_supplier alignLeft">' + poList.supplier + '</td>\
                        <td>\
                            <select class="po_qty_status">\
                                <option value="pending" ' + (poList.status == 'pending' ? 'selected' : '') + '>Chưa hoàn thành</option>\
                                <option value="incomplete" ' + (poList.status == 'incomplete' ? 'selected' : '') + '>Chưa đủ</option>\
                                <option value="complete" ' + (poList.status == 'complete' ? 'selected' : '') + '>Hoàn thành</option>\
                            </select>\
                            <input type="hidden" class="po_qty_row_id" value="'+ poList.id + '">\
                            <input type="hidden" class="po_qty_pid" value="'+ poList.pid + '">\
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

                                    var qtyReceivedList = document.querySelectorAll('#' + formTableContainer + ' .po_qty_received');
                                    var qtyDeliveredList = document.querySelectorAll('#' + formTableContainer + ' .po_qty_delivered input');
                                    var statusList = document.querySelectorAll('#' + formTableContainer + ' .po_qty_status');
                                    var rowIds = document.querySelectorAll('#' + formTableContainer + ' .po_qty_row_id');
                                    var qtyOrdered = document.querySelectorAll('#' + formTableContainer + ' .po_qty_ordered');
                                    var pids = document.querySelectorAll('#' + formTableContainer + ' .po_qty_pid');

                                    var poListsArrForm = [];
                                    for (var i = 0; i < qtyDeliveredList.length; i++) {
                                        poListsArrForm.push({
                                            qtyReceive: qtyReceivedList[i].innerText,
                                            qtyDelivered: qtyDeliveredList[i].value,
                                            status: statusList[i].value,
                                            id: rowIds[i].value,
                                            qtyOrdered: qtyOrdered[i].innerText,
                                            pid: pids[i].value,
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
                    if(classList.contains('appDeliveryHistory')){
                        let id = targetElement.dataset.id;
                        
                        $.get('database/view-delivery-history.php', {id: id}, function(data){
                            if(data.length) {
                                rows = '';
                                data.forEach((row, id) => {
                                    receivedDate = new Date(row['date_received']);
                                    row += '\
                                    <tr>\
                                        <td>'+ (id + 1) +'</td>\
                                        <td>'+ receivedDate.toUTCString() + '' + receivedDate.getUTCHours() + ":" + receivedDate.getUTCMinutes() +'</td>\
                                        <td>'+ row['qty_received'] +'</td>\
                                    </tr>';
                                });

                                var deliveryHistoryHtml = '<table class="deliveryHitoryTable">\
                                    <thead>\
                                        <tr>\
                                            <th>#</th>\
                                            <th>Ngày nhận được</th>\
                                            <th>Số lượng nhận được</th>\
                                        </tr>\
                                    </thead>\
                                    <tbody>'+ rows +'</tbody>\
                                </table>';

                                BootstrapDialog.show({
                                    title: '<strong>Lịch sử giao hàng</strong>',
                                    type: BootstrapDialog.TYPE_PRIMARY,
                                    message: deliveryHistoryHtml,
                                })

                            } else {
                                BootstrapDialog.alert({
                                    title: '<strong>Không có lịch sử giao hàng</strong>',
                                    type: BootstrapDialog.TYPE_INFO,
                                    message: "Không tìm thấy lịch sử giao hàng trên sản phẩm đã chọn."
                                });
                            };
                            console.log(data);
                        }, 'json');
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