<?php
    $servername = "localhost";
    $username = "root";
    $password = "";

    // Create connection
    try{
        $conn = new PDO("mysql:host=$servername;dbname=kho", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
    }catch(PDOException $e){
        $error_message = $e->getMessage();
    }

?>