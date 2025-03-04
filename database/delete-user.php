<?php
$data = $_POST;
$user_id = (int) $data['user_id'];
$first_name = $data['f_name'];
$last_name = $data['l_name'];

try {
    include('connection.php');

    $delete_method = "DELETE FROM users WHERE id = :user_id";

    $stmt = $conn->prepare($delete_method);
    $stmt->bindParam(':user_id', $user_id);

    $stmt->execute();
    $response = [
        'success' => true,
        'message' => $first_name . ' ' . $last_name . 'Người dùng đã được xoá thành công'
    ];
    echo json_encode($response);
} catch (PDOException $e) {
    echo  $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
    echo json_encode($response);
}
