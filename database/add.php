<?php
session_start(); // Bắt đầu session để lưu và sử dụng biến session

include('table_columns.php'); // Import file ánh xạ tên cột của bảng

$table_name = $_SESSION['table']; // Lấy tên bảng hiện tại từ session
$columns = $table_columns_mapping[$table_name]; // Lấy danh sách cột tương ứng với bảng

$db_arr = []; // Mảng lưu dữ liệu để insert vào DB
$user = $_SESSION['user']; // Lấy thông tin người dùng hiện tại từ session

// ========== KIỂM TRA DỮ LIỆU BẮT BUỘC ==========

// Kiểm tra Họ khi thêm người dùng
if ($table_name === 'users' && empty(trim($_POST['first_name'] ?? ''))) {
    $_SESSION['response'] = [
        'success' => false,
        'message' => 'Họ không được để trống!'
    ];
    header('location: ../' . $_SESSION['redirect_to']); // Quay lại trang trước
    exit();
}

// Kiểm tra khi thêm sản phẩm
if ($table_name === 'products') {
    // Tên sản phẩm không được để trống
    if (empty(trim($_POST['name'] ?? ''))) {
        $_SESSION['response'] = [
            'success' => false,
            'message' => 'Tên sản phẩm không được để trống!'
        ];
        header('location: ../' . $_SESSION['redirect_to']);
        exit();
    }

    // Phải chọn ít nhất một nhà cung cấp
    if (!isset($_POST['suppliers']) || !is_array($_POST['suppliers']) || count($_POST['suppliers']) === 0) {
        $_SESSION['response'] = [
            'success' => false,
            'message' => 'Vui lòng chọn ít nhất một nhà cung cấp!'
        ];
        header('location: ../' . $_SESSION['redirect_to']);
        exit();
    }
}

// Kiểm tra tên nhà cung cấp khi thêm nhà cung cấp
if ($table_name === 'suppliers' && empty(trim($_POST['name'] ?? ''))) {
    $_SESSION['response'] = [
        'success' => false,
        'message' => 'Tên nhà cung cấp không được để trống!'
    ];
    header('location: ../' . $_SESSION['redirect_to']);
    exit();
}

// ========== DUYỆT QUA CÁC CỘT ĐỂ CHUẨN BỊ DỮ LIỆU ==========
foreach ($columns as $column) {
    if (in_array($column, ['created_at', 'updated_at'])) {
        $value = date('Y-m-d H:i:s'); // Gán thời gian hiện tại
    } else if ($column == 'created_by') {
        $value = $user['id']; // Gán ID người tạo
    } else if ($column == 'password') {
        $value = $_POST[$column]; // Lưu mật khẩu (nếu muốn mã hóa thì xử lý thêm)
    } else if ($column == 'img') {
        // Xử lý upload ảnh
        $target_dir = "../uploads/products/";
        $file_data = $_FILES[$column];

        $file_name = $file_data["name"];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = 'product-' . time() . '.' . $file_ext;

        $check = getimagesize($file_data['tmp_name']); // Kiểm tra có phải file ảnh

        if ($check) {
            if (move_uploaded_file($file_data['tmp_name'], $target_dir . $new_file_name)) {
                $value = $new_file_name; // Upload thành công
            } else {
                $value = ''; // Upload thất bại
            }
        } else {
            $value = ''; // Không phải file ảnh
        }
    } else {
        // Với các cột còn lại, lấy dữ liệu từ POST
        $value = isset($_POST[$column]) ? $_POST[$column] : '';
    }

    $db_arr[$column] = $value; // Gán vào mảng dữ liệu
}

// Tạo chuỗi tên cột và placeholder để thực thi SQL
$table_properties = implode(", ", array_keys($db_arr));
$table_placeholders = ':' . implode(", :", array_keys($db_arr));

// Nếu bảng có trường 'permissions' và không chọn
if (isset($db_arr['permissions']) && $db_arr['permissions'] == '') {
    $_SESSION['response'] = [
        'success' => false,
        'message' => 'Hãy Chọn Quyền Người Dùng!'
    ];
    header('location: ../' . $_SESSION['redirect_to']);
    exit();
}

try {
    include('connection.php'); // Kết nối CSDL

    // Tạo câu lệnh SQL INSERT
    $sql = "INSERT INTO $table_name($table_properties) VALUES ($table_placeholders)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($db_arr); // Thực thi với dữ liệu từ form
    $product_id = $conn->lastInsertId(); // Lấy ID sản phẩm mới thêm

    // Nếu đang thêm sản phẩm, lưu nhà cung cấp vào bảng productsuppliers
    if ($table_name === 'products' && isset($_POST['suppliers']) && is_array($_POST['suppliers'])) {
        foreach ($_POST['suppliers'] as $supplier_id) {
            $sql = "INSERT INTO productsuppliers (product, supplier) VALUES (:product_id, :supplier_id)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'product_id' => $product_id,
                'supplier_id' => $supplier_id
            ]);
        }
    }

    // Thông báo thành công
    $response = [
        'success' => true,
        'message' => 'Thêm thành công vào hệ thống.'
    ];
} catch (PDOException $e) {
    // Bắt lỗi và trả thông báo nếu có lỗi DB
    $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
}

// Lưu kết quả vào session và quay lại trang cũ
$_SESSION['response'] = $response;
header('location: ../' . $_SESSION['redirect_to']);
