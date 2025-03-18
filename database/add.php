<?php


session_start();


include('table_columns.php');

include('connection.php');


$table_name = $_SESSION['table'];
$columns = $table_columns_mapping[$table_name];


$user = $_SESSION['user'];

// Lấy username từ dữ liệu form
$first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : [''];
$last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : [''];

if (!$first_name || !$last_name) {
    $_SESSION['response'] = [
        'success' => false,
        'message' => 'Vui lòng nhập tên người dùng.'
    ];
    header('location: ../' . $_SESSION['redirect_to']);
    exit();
}

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

// Nếu username chưa tồn tại, tiếp tục xử lý thêm người dùng
$db_arr = [];

foreach ($columns as $column) {
    if (in_array($column, ['created_at', 'updated_at'])) {
        $value = date('Y-m-d H:i:s');
    } else if ($column == 'created_by') {
        $value = $user['id'];
    } else if ($column == 'password') {
        $value = password_hash($_POST[$column], PASSWORD_DEFAULT);
    } else {
        $value = isset($_POST[$column]) ? $_POST[$column] : '';
    }

    $db_arr[$column] = $value;
}

// Tạo chuỗi danh sách các cột và placeholder
$table_properties = implode(", ", array_keys($db_arr));
$table_placeholders = ':' . implode(", :", array_keys($db_arr));

try {
    // Tạo truy vấn SQL để chèn dữ liệu
    $sql = "INSERT INTO $table_name ($table_properties) VALUES ($table_placeholders)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($db_arr);

    // Trả về phản hồi thành công
    $_SESSION['response'] = [
        'success' => true,
        'message' => 'Thêm thành công vào hệ thống.'
    ];
} catch (PDOException $e) {
    $_SESSION['response'] = [
        'success' => false,
        'message' => $e->getMessage()
    ];
}

// Chuyển hướng về trang trước đó
header('location: ../' . $_SESSION['redirect_to']);
