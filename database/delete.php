<?php
$data = $_POST;
$id = (int) $data['id'];
$table = $data['table'];

try {
    include('connection.php');

    $delete_method = "DELETE FROM table WHERE id = :id";

    $stmt = $conn->prepare($delete_method);
    $stmt->bindParam(':user_id', $user_id);

    $stmt->execute();
    $response = [
        'success' => true,
    ];
    echo json_encode($response);
} catch (PDOException $e) {
    echo  $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
    echo json_encode($response);
}
