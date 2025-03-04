<?php
session_start();
$table_name = $_SESSION['table'];

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$created_at = date('Y-m-d H:i:s');
$updated_at = date('Y-m-d H:i:s');
$encrypted = password_hash($password, PASSWORD_DEFAULT);
try {
    include('connection.php');

    $insert_method = "INSERT INTO `$table_name` (first_name, last_name, email, password, created_at, updated_at) 
                        VALUES (:first_name, :last_name, :email, :password, :created_at, :updated_at)";

    $stmt = $conn->prepare($insert_method);
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $encrypted);
    $stmt->bindParam(':created_at', $created_at);
    $stmt->bindParam(':updated_at', $updated_at);

    $stmt->execute();
    $response = [
        'success' => true,
        'message' => $first_name . ' ' . $last_name . ' đã được thêm thành công'
    ];
} catch (PDOException $e) {
    echo  $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
}
$_SESSION['response'] = $response;
header('location: ../user_add.php');
