<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "kho";

    // Create connection
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Bỏ dòng echo này trong production
        // echo "Connected successfully";
    } catch(PDOException $e) {
        $error_message = $e->getMessage();
        // Thêm xử lý lỗi phù hợp, ví dụ:
        // error_log("Database connection error: " . $error_message);
    }
?>