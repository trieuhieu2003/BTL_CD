<?php
include('connection.php');
$status = ['pending', 'completed', 'incomplete'];

$result = [];

// loop throuh statuses and query
foreach ($status as $status) {
    $stmt = $conn->prepare("SELECT  COUNT(*) AS status_count FROM order_product WHERE order_product.status = '".$status."'");
    $stmt->execute();
    $row = $stmt->Fetch();

    $count = $row['status_count'];

    $result[] = [
        'name' => strtoupper($status),
        'y' => (int) $count
    ];
}
?>


