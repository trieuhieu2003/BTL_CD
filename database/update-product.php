<?php

$product_name = $_POST['product_name'];
$description = $_POST['description'];
$pid = $_POST['pid'];

$target_dir = "../uploads/products/";
$file_name_value = NULL;
$file_data = $_FILES['img'];  // Giữ nguyên mảng file_data

if ($file_data['tmp_name'] !== '') {
    $file_name = $file_data["name"];  // Lấy tên file từ mảng
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);  // Lấy phần mở rộng của file

    $new_file_name = 'product-' . time() . '.' . $file_ext;  // Tạo tên mới cho file

    $check = getimagesize($file_data['tmp_name']);  // Kiểm tra xem file có phải là hình ảnh không


    if ($check) {
        if (move_uploaded_file($file_data['tmp_name'], $target_dir . $new_file_name)) {
            $file_name_value = $new_file_name;  // Gán tên file mới
        }
    }
}

try {
    //Lưu vào database
    $sql = "UPDATE products SET product_name =? , description =? , img =?  WHERE id =? ";

    // Kết nối đến cơ sở dữ liệu
    include('connection.php');

    // Chuẩn bị và thực thi truy vấn
    $stmt = $conn->prepare($sql);
    $stmt->execute([$product_name, $description, $file_name_value, $pid]);

    //xoá dữ liệu cũ
    $sql = "DELETE FROM productsuppliers WHERE product = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$pid]);


    //lấy dữ liệu
    $suppliers = isset($_POST['suppliers']) ? $_POST['suppliers'] : [];

    foreach ($suppliers as $supplier) {
        $supplier_data = [
            'supplier_id' => $supplier,
            'product_id' => $pid,
            'updated_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $sql = "INSERT INTO productsuppliers (supplier, product, updated_at, created_at) VALUES (:supplier_id, :product_id, :updated_at, :created_at)";

        // Chuẩn bị và thực thi truy vấn
        $stmt = $conn->prepare($sql);
        $stmt->execute($supplier_data);
    }

    // Trả về phản hồi thành công
    $response = [
        'success' => true,
        'message' => "<strong>$product_name</strong> Cập nhật thành công vào hệ thống."
    ];
    echo json_encode($response); // Thêm dòng này để gửi phản hồi về client
} catch (PDOException $e) {
    $response = [
        'success' => false,
        'message' => "Lỗi cập nhật sản phẩm"
    ];
    echo json_encode($response);
}
