<?php

$product_name = $_POST['product_name'];
$description = $_POST['description'];
$pid = $_POST['pid'];

$target_dir = "../uploads/products/";
$file_name_value = NULL;
$file_data = $_FILES['img'];

include('connection.php');

// Lấy ảnh cũ từ DB
$sql = "SELECT img FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$pid]);
$result = $stmt->fetch();
$old_file_name = $result['img'];

if ($file_data['tmp_name'] !== '') {
    $file_name = $file_data["name"];
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $new_file_name = 'product-' . time() . '.' . $file_ext;

    $check = getimagesize($file_data['tmp_name']);
    if ($check) {
        if (move_uploaded_file($file_data['tmp_name'], $target_dir . $new_file_name)) {
            $file_name_value = $new_file_name;
        }
    }
} else {
    $file_name_value = $old_file_name;
}

try {
    // Cập nhật sản phẩm
    $sql = "UPDATE products SET product_name =?, description =?, img =? WHERE id =?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$product_name, $description, $file_name_value, $pid]);

    // Kiểm tra và cập nhật supplier nếu có dữ liệu mới
    $suppliers = isset($_POST['suppliers']) ? $_POST['suppliers'] : [];

    if (!empty($suppliers)) {
        // Xoá supplier cũ
        $sql = "DELETE FROM productsuppliers WHERE product = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$pid]);

        // Thêm supplier mới
        foreach ($suppliers as $supplier) {
            $supplier_data = [
                'supplier_id' => $supplier,
                'product_id' => $pid,
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $sql = "INSERT INTO productsuppliers (supplier, product, updated_at, created_at) VALUES (:supplier_id, :product_id, :updated_at, :created_at)";
            $stmt = $conn->prepare($sql);
            $stmt->execute($supplier_data);
        }
    }

    // Trả về phản hồi thành công
    $response = [
        'success' => true,
        'message' => "<strong>$product_name</strong> Cập nhật thành công vào hệ thống."
    ];
    echo json_encode($response);
} catch (PDOException $e) {
    $response = [
        'success' => false,
        'message' => "Lỗi cập nhật sản phẩm: " . $e->getMessage()
    ];
    echo json_encode($response);
}
?>
