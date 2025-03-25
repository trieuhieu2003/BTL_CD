<?php

$json = file_get_contents('php://input');
$data = json_decode($json, true);
$purchase_orders = $data['payload'];

include('connection.php');

try {
    foreach ($purchase_orders as $po) {
        $received = (int) $po['qtyReceived'];
        $status = $po['status'];
        $row_id = $po['id'];
        $qty_ordered = (int) $po['qtyOrdered'];

        $qty_remaining = $qty_ordered - $received;

        $sql = "UPDATE order_product 
                SET quantity_received = ?, status = ?, quantity_remaining = ? 
                WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$received, $status, $qty_remaining, $row_id]);
    }
    $response = [
        'success' => true,
        'message' => "Cập nhật thành công đơn hàng"
    ];
} catch (\Exception $e) {
    $response = [
        'success' => false,
        'message' => "Lỗi! Cập nhật lại: " . $e->getMessage()
    ];
}

header('Content-Type: application/json');
echo json_encode($response);