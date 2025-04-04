<?php
include('connection.php');

// Lấy danh sách nhà cung cấp
$stmt = $conn->prepare("SELECT id, supplier_name FROM suppliers");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$categories = [];  // Lưu tên nhà cung cấp
$bar_chart_data = []; // Lưu số lượng sản phẩm theo nhà cung cấp

// Danh sách màu cho biểu đồ
$colors = ['#FF0000', '#0000FF', '#ADD8E6', '#800080', '#00FF00', '#FF00FF', '#FFA500', '#800000'];
$counter = 0;

foreach ($rows as $row) {
    $id = $row['id'];
    $categories[] = $row['supplier_name'];

    // Truy vấn số lượng sản phẩm của nhà cung cấp
    $stmt = $conn->prepare("SELECT COUNT(*) AS p_count FROM productsuppliers WHERE supplier = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetch(PDO::FETCH_ASSOC)['p_count'];

    // Thêm dữ liệu vào biểu đồ
    $bar_chart_data[] = [
        'y' => (int) $count,
        'color' => $colors[$counter % count($colors)]
    ];
    $counter++;
}
?>