<?php
$data = $_POST;
$id = (int) $data['id'];
$table = $data['table'];

try {
    include('connection.php');
    //xoá nhà cung cấp
    if ($table === 'suppliers') {
        $delete_method = "DELETE FROM $table WHERE id = :id";
        $stmt = $conn->prepare($delete_method);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }


    $delete_method = "DELETE FROM $table WHERE id = :id";
    $stmt = $conn->prepare($delete_method);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    $stmt->execute();
    $response = [
        'success' => true,
        'message' => 'Xóa sản phẩm thành công'
    ];
    echo json_encode($response);
} catch (PDOException $e) {
    $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
    echo json_encode($response);
}
