<?php
include('connection.php');
//query supplier 
$stmt = $conn->prepare("SELECT id, supplier_name  FROM suppliers ");
$stmt->execute();
$rows = $stmt->FetchAll();
$categories = [];
$bar_chart_data = [];

$colors = ['#FF0000','#0000FF','#ADD8E6','#8000080','#00FF00','#FF00FF','#FFA500','#800000'];
$counter = 0;
//query supplier product count
foreach ($rows as $key => $row) {

    $id = $row['id'];
    $categories[] = $row['supplier_name'];

//query count
$stmt = $conn->prepare("SELECT  COUNT(*) AS p_count FROM productsuppliers WHERE productsuppliers.supplier = '".$id."'");
    $stmt->execute();
    $row = $stmt->Fetch();

    $count = $row['p_count'];

    if(isset($colors[$key])) $counter = 0;
    $bar_chart_data[] = [
        'y' => (int) $count,
        'color' => $colors[$counter]
    ];

    $counter++;
    


}
?>
