<?php
include('connection.php');

$id = $_GET['id'];

try {
    // Lấy thông tin sản phẩm
    $get_product = "SELECT * FROM products WHERE id = :id";
    $stmt = $conn->prepare($get_product);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        throw new Exception("Không tìm thấy sản phẩm.");
    }

    // Lấy danh sách nhà cung cấp
    $stmt = $conn->prepare("SELECT supplier_name, suppliers.id FROM suppliers, productsuppliers WHERE productsuppliers.product = :id AND productsuppliers.supplier = suppliers.id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Thêm danh sách nhà cung cấp vào dữ liệu sản phẩm
    $product['suppliers'] = array_column($suppliers, 'id');

    // Gửi phản hồi JSON duy nhất
    echo json_encode($product);
} catch (PDOException $e) {
    $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
    echo json_encode($response);
} catch (Exception $e) {
    $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
    echo json_encode($response);
}
