<?php

// Bắt đầu phiên làm việc.
session_start();

// Lấy dữ liệu ánh xạ cột của bảng.
include('table_columns.php');

// Lấy tên bảng từ session.
$table_name = $_SESSION['table'];
$columns = $table_columns_mapping[$table_name];

// Duyệt qua các cột trong bảng.  
$db_arr = [];
$user = $_SESSION['user'];

foreach ($columns as $column) {
    if (in_array($column, ['created_at', 'updated_at'])) {
        // Nếu là cột 'created_at' hoặc 'updated_at' thì gán giá trị ngày giờ hiện tại.
        $value = date('Y-m-d H:i:s');
    } else if ($column == 'created_by') {
        // Nếu là cột 'created_by' thì gán ID của người dùng hiện tại.
        $value = $user['id'];
    } else if ($column == 'password') {
        // BỎ mã hóa mật khẩu, lưu trực tiếp vào database.
        $value = $_POST[$column];
    } else if ($column == 'img') {
        // Nếu là cột 'img' thì xử lý file hình ảnh.
        $target_dir = "../uploads/products/";
        $file_data = $_FILES[$column];

        $file_name = $file_data["name"];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

        $new_file_name = 'product-' . time() . '.' . $file_ext;

        $check = getimagesize($file_data['tmp_name']);

        if ($check) {
            if (move_uploaded_file($file_data['tmp_name'], $target_dir . $new_file_name)) {
                $value = $new_file_name;
            } else {
                $value = '';  // Nếu không upload được file
            }
        } else {
            // Nếu file không phải là hình ảnh
            $value = '';
        }
    } else {
        // Nếu không phải các cột đặc biệt, lấy giá trị từ POST
        $value = isset($_POST[$column]) ? $_POST[$column] : '';
    }

    // Gán giá trị cho mảng db_arr
    $db_arr[$column] = $value;
}

// Tạo chuỗi danh sách các cột của bảng.
$table_properties = implode(", ", array_keys($db_arr));
// Tạo danh sách các placeholder tương ứng để sử dụng trong truy vấn SQL.
$table_placeholders = ':' . implode(", :", array_keys($db_arr));

if (isset($db_arr['permissions'])) {
    if ($db_arr['permissions'] == '') {
        $_SESSION['response'] = [
            'success' => false,
            'message' => 'Hãy Chọn Quyền Người Dùng!'
        ];

        header('location: ../' . $_SESSION['redirect_to']);
        die;
    }
}

try {
    // Tạo truy vấn SQL để chèn dữ liệu vào bảng products
    $sql = "INSERT INTO 
                $table_name($table_properties)
            VALUES 
                ($table_placeholders)";

    // Kết nối đến cơ sở dữ liệu
    include('connection.php');

    // Thực thi truy vấn và lấy ID sản phẩm vừa thêm
    $stmt = $conn->prepare($sql);
    $stmt->execute($db_arr);
    $product_id = $conn->lastInsertId(); // Lấy ID của sản phẩm mới

    // Xử lý thêm nhà cung cấp vào bảng productsuppliers
    if ($table_name === 'products' && isset($_POST['suppliers']) && is_array($_POST['suppliers'])) {
        $suppliers = $_POST['suppliers'];

        foreach ($suppliers as $supplier_id) {
            $sql = "INSERT INTO productsuppliers (product, supplier) VALUES (:product_id, :supplier_id)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'product_id' => $product_id,
                'supplier_id' => $supplier_id
            ]);
        }
    }

    // Trả về phản hồi thành công
    $response = [
        'success' => true,
        'message' => 'Thêm thành công vào hệ thống.'
    ];
} catch (PDOException $e) {
    // Trả về phản hồi lỗi nếu có lỗi xảy ra
    $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
}

$_SESSION['response'] = $response;
header('location: ../' . $_SESSION['redirect_to']);
?>
