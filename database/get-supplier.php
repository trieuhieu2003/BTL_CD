<?php
include('connection.php');

$id = $_GET['id'];

try {
    // Lấy thông tin nhà cung cấp
    $get_product = "SELECT * FROM suppliers WHERE id = :id";
    $stmt = $conn->prepare($get_product);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        throw new Exception("Không tìm thấy nhà cung cấp.");
    }

    // Lấy danh sách sản phẩm
    $stmt = $conn->prepare("SELECT product_name, products.id FROM products, productsuppliers WHERE productsuppliers.supplier = :id AND productsuppliers.product = products.id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Thêm danh sách sản phẩm vào dữ liệu nhà cung cấp
    $product['products'] = array_column($products, 'id');

    // Gửi phản hồi JSON
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
