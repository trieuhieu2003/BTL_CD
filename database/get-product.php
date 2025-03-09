<?php

include('connection.php');

$id = $_GET['id'];

try {
    $get_product = "SELECT * FROM products WHERE id = :id";
    $stmt = $conn->prepare($get_product);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($product);
} catch (PDOException $e) {
    echo $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
    echo json_encode($response);
}
