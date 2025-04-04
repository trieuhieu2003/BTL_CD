<?php
$data = $_POST;
$user_id = (int) $data['userId'];
$first_name = $data['f_name'];
$last_name = $data['l_name'];
$email = $data['email'];
$permissons = isset($data['permissions']) ? $data['permissions'] : '';

if($permissons == ''){
    echo json_encode([
        'success' => false,
        'message' => 'Xác nhận'
    ]);
    return;
}


try {
    include('connection.php');

    $update_query = "UPDATE users SET 
                        first_name = :first_name, 
                        last_name = :last_name, 
                        email = :email,
                        updated_at = :updated_at,
                        permissions = :permissions
                      WHERE id = :user_id";

    $stmt = $conn->prepare($update_query);

    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam('updated_at', $updated_at);
    $stmt->bindParam('permissions', var: $permissons);

    $stmt->execute();

    $response = [
        'success' => true,
        'message' => $first_name . ' ' . $last_name . ' cập nhật thành công!'
    ];
} catch (PDOException $e) {
    $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
}

echo json_encode($response);