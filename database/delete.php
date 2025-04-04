<?php
$data = $_POST;
$id = (int) $data['id'];
$table = $data['table'];

try {
    include('connection.php');

    // Xử lý xoá sản phẩm và dữ liệu liên quan
    if ($table === 'products') {
        // Xoá các bản ghi liên quan trong order_product trước
        $sql_delete_order_product = "DELETE FROM order_product WHERE product = :id";
        $stmt = $conn->prepare($sql_delete_order_product);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Sau đó xoá sản phẩm
        $sql_delete_product = "DELETE FROM products WHERE id = :id";
        $stmt = $conn->prepare($sql_delete_product);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
    }
    // Xử lý các trường hợp khác (suppliers, ...)
    else {
        $delete_method = "DELETE FROM $table WHERE id = :id";
        $stmt = $conn->prepare($delete_method);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    $response = [
        'success' => true,
        'message' => 'Xóa thành công.'
    ];
} catch (PDOException $e) {
    $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
}

echo json_encode($response);
