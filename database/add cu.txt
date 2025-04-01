<?php
session_start();
include('table_columns.php'); // File chứa mảng $table_columns_mapping định nghĩa các cột của từng bảng
include('connection.php');    // File chứa kết nối PDO đến cơ sở dữ liệu

// Lấy thông tin bảng và người dùng từ session
$table_name = $_SESSION['table'];
$columns = $table_columns_mapping[$table_name];
$user = $_SESSION['user'];

// Kiểm tra dữ liệu đầu vào dựa trên bảng
if ($table_name == 'users') {
    $first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';

    // Kiểm tra trường bắt buộc
    if (empty($first_name) || empty($last_name)) {
        $_SESSION['response'] = [
            'success' => false,
            'message' => 'Vui lòng nhập tên người dùng.'
        ];
        header('location: ../' . $_SESSION['redirect_to']);
        exit();
    }

    // Kiểm tra trùng lặp người dùng
    $check_sql = "SELECT COUNT(*) FROM $table_name WHERE first_name = :first_name AND last_name = :last_name";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->execute(['first_name' => $first_name, 'last_name' => $last_name]);
    $user_exists = $check_stmt->fetchColumn();

    if ($user_exists) {
        $_SESSION['response'] = [
            'success' => false,
            'message' => 'Tên người dùng đã tồn tại. Vui lòng chọn tên khác.'
        ];
        header('location: ../' . $_SESSION['redirect_to']);
        exit();
    }
} elseif ($table_name == 'products') {
    // Kiểm tra trường bắt buộc
    if (empty($_POST['product_name'])) {
        $_SESSION['response'] = [
            'success' => false,
            'message' => 'Vui lòng nhập tên sản phẩm.'
        ];
        header('location: ../' . $_SESSION['redirect_to']);
        exit();
    }
}

// Chuẩn bị dữ liệu để chèn vào cơ sở dữ liệu
$db_arr = [];
foreach ($columns as $column) {
    if ($table_name == 'products' && $column == 'image') {
        // Xử lý tải lên hình ảnh cho sản phẩm
        if (isset($_FILES['img']) && $_FILES['img']['error'] == UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $file_name = basename($_FILES['img']['name']);
            $target_file = $upload_dir . $file_name;
            if (move_uploaded_file($_FILES['img']['tmp_name'], $target_file)) {
                $value = $file_name;
            } else {
                $value = '';
            }
        } else {
            $value = '';
        }
    } elseif (in_array($column, ['created_at', 'updated_at'])) {
        // Gán thời gian hiện tại
        $value = date('Y-m-d H:i:s');
    } elseif ($column == 'created_by') {
        // Gán ID của người tạo
        $value = $user['id'];
    } elseif ($column == 'password' && $table_name == 'users') {
        // Mã hóa mật khẩu cho bảng users
        $value = password_hash($_POST[$column], PASSWORD_DEFAULT);
    } else {
        // Lấy giá trị từ form hoặc để trống nếu không có
        $value = isset($_POST[$column]) ? $_POST[$column] : '';
    }
    $db_arr[$column] = $value;
}

// Tạo truy vấn SQL
$table_properties = implode(", ", array_keys($db_arr));
$table_placeholders = ':' . implode(", :", array_keys($db_arr));

try {
    // Thực thi truy vấn chèn dữ liệu
    $sql = "INSERT INTO $table_name ($table_properties) VALUES ($table_placeholders)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($db_arr);
    $_SESSION['response'] = [
        'success' => true,
        'message' => 'Thêm thành công vào hệ thống.'
    ];
} catch (PDOException $e) {
    // Xử lý lỗi nếu có
    $_SESSION['response'] = [
        'success' => false,
        'message' => 'Lỗi: ' . $e->getMessage()
    ];
}

// Chuyển hướng người dùng về trang trước đó
header('location: ../' . $_SESSION['redirect_to']);
exit();
