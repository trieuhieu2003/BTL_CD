<?php
include('connection.php');
//query supplier 
$stmt = $conn->prepare("SELECT qty_received, date_received  FROM order_product_history ORDER BY  date_received ASC  ");
$stmt->execute();
$rows = $stmt->FetchAll();

$line_categories = [];
$line_data = [];
foreach ($rows as $row) {
    $key =date('Y-m-d', strtotime($row['date_received'])); 
    $line_categories[] = $key;

    $line_data[] = isset($line_data[$key]) ? $line_data[$key] + (int) $row['qty_received'] : (int) $row['qty_received'];

}

$line_categories   =array_key($line_data);
$line_data =array_values($line_data);

?>


