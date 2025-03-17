<?php
session_start();
include('connection.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user'])) {
    header('location: login.php');
    exit;
}

// Nhận dữ liệu từ form
$supplier_name = $_POST['supplier_name'];
$supplier_location = $_POST['supplier_location'];
$email = $_POST['email'];
$sid = $_POST['sid'];

try {
    // Cập nhật thông tin nhà cung cấp trong bảng suppliers
    $sql = "UPDATE suppliers SET supplier_name = ?, supplier_location = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$supplier_name, $supplier_location, $email, $sid]);

    // Xóa các bản ghi liên kết cũ trong bảng productsuppliers cho nhà cung cấp này
    $sql = "DELETE FROM productsuppliers WHERE supplier = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$sid]);

    // Lấy danh sách sản phẩm được chọn từ form
    $products = isset($_POST['products']) ? $_POST['products'] : [];

    // Thêm các bản ghi liên kết mới vào bảng productsuppliers
    foreach ($products as $product) {
        $product_data = [
            'supplier_id' => $sid,
            'product_id' => $product,
            'updated_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $sql = "INSERT INTO productsuppliers (supplier, product, updated_at, created_at) VALUES (:supplier_id, :product_id, :updated_at, :created_at)";
        $stmt = $conn->prepare($sql);
        $stmt->execute($product_data);
    }

    // Trả về phản hồi thành công
    $response = [
        'success' => true,
        'message' => "<strong>$supplier_name</strong> Cập nhật thành công."
    ];
    echo json_encode($response);
} catch (PDOException $e) {
    $response = [
        'success' => false,
        'message' => "Lỗi cập nhật nhà cung cấp: " . $e->getMessage()
    ];
    echo json_encode($response);
}
