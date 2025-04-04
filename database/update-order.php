<?php
if (isset($_POST['payload']) && is_array($_POST['payload'])) {
    $purchase_orders = $_POST['payload'];
    include('connection.php');

    try {
        foreach ($purchase_orders as $po) {
            $delivered = (int) $po['qtyDelivered'];

            if ($delivered > 0) {
                $cur_qty_received = (int) $po['qtyReceive'];
                $status = $po['status'];
                $row_id = $po['id'];
                $qty_ordered = (int) $po['qtyOrdered'];

                $product_id = (int) $po['pid'];

                // Update quantity received
                $updated_qty_received = $cur_qty_received + $delivered;
                $qty_remaining = $qty_ordered - $updated_qty_received;

                // var_dump($updated_qty_received);
                // var_dump($status);
                // var_dump($qty_remaining);
                // var_dump($row_id);
                // die();

                $sql = "UPDATE order_product SET quantity_received=?, status =?, quantity_remaining =? WHERE id =?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$updated_qty_received, $status, $qty_remaining, $row_id]);

                // var_dump($stmt->fetch());
                // die();

                // Insert script adding to the order_product_history
                $delivery_history = [
                    'order_product_id' => $row_id,
                    'qty_received' => $delivered,
                    'date_received' => date('Y-m-d H:i:s'),
                    'date_updated' => date('Y-m-d H:i:s'),
                ];

                $sql = "INSERT INTO order_product_history (order_product_id, qty_received, date_received, date_updated) VALUES (:order_product_id, :qty_received, :date_received, :date_updated)";
                $stmt = $conn->prepare($sql);
                $stmt->execute($delivery_history);

                // Script for updating the main product quantity
                // Select statement - to pull the current quantity of the product
                $stmt = $conn->prepare("SELECT stock FROM product WHERE id = ?");
                $stmt->execute([$product_id]);
                $product = $stmt->fetch();

                $cur_stock = (int) $product['stock'];

                // Update statement - to add the delivered product to te cur quantity
                $updated_stock = $cur_stock + $delivered;
                $sql = "UPDATE product SET stock=? WHERE id =?";

                $stmt = $conn->prepare($sql);
                $stmt->execute([$updated_stock, $product_id]);
            }
        }

        $response = [
            'success' => true,
            'message' => 'Đơn đặt hàng đã được cập nhật thành công!'
        ];
    } catch (\Exception $e) {
        $response = [
            'success' => false,
            'message' => 'Lỗi khi xử lý yêu cầu của bạn'
        ];
    }
} else {
    $response = [
        'success' => false,
        'message' => 'Dữ liệu payload không tồn tại hoặc không đúng định dạng.'
    ];
}

echo json_encode($response);
?>