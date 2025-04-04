<?php
session_start();

$post_data = $_POST;
$products = $post_data['products_name'];
$qty = array_values($post_data['quantity']);

// Mảng chứa dữ liệu sản phẩm và số lượng
$post_data_arr = [];

foreach ($products as $key => $pid) {
    if (isset($qty[$key])) {
        // Gắn kết sản phẩm với số lượng tương ứng
        $post_data_arr[$pid] = $qty[$key];
    }
}

// Kết nối cơ sở dữ liệu
include('connection.php');

$batch = time(); // Dùng thời gian hiện tại làm batch

$success = false;

try {
    // Duyệt qua từng sản phẩm và số lượng
    foreach ($post_data_arr as $pid => $supplier_qty) {
        // Duyệt qua từng nhà cung cấp và số lượng tương ứng
        foreach ($supplier_qty as $sid => $qty) {
            // Chạy lệnh SQL chèn vào cơ sở dữ liệu
            echo $pid . ' . ' . $sid . ' . ' . $qty . '<br/>';

            $value = [
                'supplier' => $sid,
                'product' => $pid,
                'quantity_ordered' => $qty,
                'status' => 'pending',
                'batch' => $batch,
                'created_by' => $_SESSION['user']['id'],
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            // Lệnh SQL chuẩn bị để insert dữ liệu
            $sql = "INSERT INTO order_product 
                    (supplier, product, quantity_ordered, status, batch, created_by, updated_at, created_at) 
                    VALUES 
                    (:supplier, :product, :quantity_ordered, :status, :batch, :created_by, :updated_at, :created_at)";

            // Thực thi câu lệnh SQL
            $stmt = $conn->prepare($sql);
            $stmt->execute($value);
        }
    }

    // Nếu không có lỗi thì trả về thông báo thành công
    $success = true;
    $message = 'Tạo Thành Công';

} catch (\Exception $e) {
    // Nếu có lỗi thì thông báo lỗi
    $message = $e->getMessage();
}

// Lưu thông báo vào session để hiển thị trên trang
$_SESSION['response'] = [
    'message' => $message,
    'success' => $success
];

// Chuyển hướng về trang danh sách đơn hàng
header('location: ../product-order.php');
exit();
?>
