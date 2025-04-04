<?php
include('connection.php');

// Truy vấn số lượng đơn hàng theo trạng thái
$stmt = $conn->prepare("SELECT status, COUNT(*) AS status_count FROM order_product GROUP BY status");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Chuyển đổi dữ liệu thành định dạng Highcharts
$chartData = [];
foreach ($result as $row) {
    $chartData[] = [
        'name' => strtoupper($row['status']),
        'y' => (int) $row['status_count']
    ];
}
?>

