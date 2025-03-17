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
        // Nếu là cột 'password' thì mã hóa mật khẩu trước khi lưu.
        $value = password_hash($_POST[$column], PASSWORD_DEFAULT);
    } else if ($column == 'img') {
        // Nếu là cột 'img' thì xử lý file hình ảnh.
        $target_dir = "../uploads/products/";
        $file_data = $_FILES[$column];  // Giữ nguyên mảng file_data

        $value = NULL;
        $file_data = $_FILES['img'];  // Giữ nguyên mảng file_data

        if ($file_data['tmp_name'] !== '') {
            $file_name = $file_data["name"];  // Lấy tên file từ mảng
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);  // Lấy phần mở rộng của file

            $new_file_name = 'product-' . time() . '.' . $file_ext;  // Tạo tên mới cho file

            $check = getimagesize($file_data['tmp_name']);  // Kiểm tra xem file có phải là hình ảnh không


            if ($check) {
                if (move_uploaded_file($file_data['tmp_name'], $target_dir . $new_file_name)) {
                    $value = $file_name;  // Gán tên file mới
                }
            }
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

// ghi vào bảng chính
try {
    // Tạo truy vấn SQL để chèn dữ liệu vào bảng
    $sql = "INSERT INTO 
                $table_name($table_properties)
            VALUES 
                ($table_placeholders)";

    // Kết nối đến cơ sở dữ liệu
    include('connection.php');

    // Chuẩn bị và thực thi truy vấn
    $stmt = $conn->prepare($sql);
    $stmt->execute($db_arr);

    // Lay id cua co so du lieu
    $product_id = $conn->lastInsertId();

    // thêm nhà cung cấp
    if ($table_name === 'products') {
        $suppliers = isset($_POST['suppliers']) ? $_POST['suppliers'] : [];
        if ($suppliers) {

            foreach ($suppliers as $supplier) {
                $supplier_data = [
                    'supplier_id' => $supplier,
                    'product_id' => $product_id,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $sql = "INSERT INTO productsuppliers (supplier, product, updated_at, created_at) VALUES (:supplier_id, :product_id, :updated_at, :created_at)";

                // Chuẩn bị và thực thi truy vấn
                $stmt = $conn->prepare($sql);
                $stmt->execute($supplier_data);
            }
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
