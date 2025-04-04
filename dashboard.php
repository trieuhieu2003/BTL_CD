<?php
session_start();




if (!isset($_SESSION['user'])) header('location: login.php');

//get session user from database
$user = $_SESSION['user'];

    $user = $_SESSION['user'];
//get graph data -purcher order by status
    include('database/po_status_pie_graph.php');
//get graph data - supplier product count
    include('database/suppier_product_bar_graph.php');
//get line graph data - delivery history per day
    // include('database/delivery_history.php');

$user = $_SESSION['user'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - He Thong Quan Ly Kho</title>

    <link rel="stylesheet" href="css/login.css">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <!-- <link rel="stylesheet" href="css/dashboard.css"> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <div id="dashboardMainContainer">
        <?php include('partials/app_slidebar.php')?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <div class="dashboard_content">
            <?php include('partials/app_topnav.php')?>
            <?php if(in_array('dashboard_view',$user['permissions'])){?>
                <div class="dashboard_content_main">
                <div class="col50">
                <div id="container" style="width: 80%; height: 500px; margin: auto;" ></div>
                </div>
    <script>
        var graphData = <?= json_encode($chartData) ?>;

        Highcharts.chart('container', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Trạng thái đơn hàng'
            },
            tooltip: {
                pointFormatter: function () {
                    return `<b>${this.name}</b>: ${this.y}`;
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                name: 'Số lượng',
                colorByPoint: true,
                data: graphData
            }]
        });
    </script>
                    <div class="col50">
                    <div id="containerBarChart" style="width: 80%; height: 500px; margin: auto;"></div>
                    </div>

<script>
    var barGraphCategories = <?= json_encode($categories) ?>;
    var barGraphData = <?= json_encode($bar_chart_data) ?>;

    Highcharts.chart('containerBarChart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Số lượng sản phẩm giao cho nhà cung cấp'
        },
        xAxis: {
            categories: barGraphCategories,
            title: {
                text: 'Nhà cung cấp'
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Số lượng sản phẩm'
            }
        },
        tooltip: {
            pointFormatter: function () {
                return `<b>${this.category}</b>: ${this.y} sản phẩm`;
            }
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Số lượng',
            data: barGraphData
        }]
    });
</script>
                    <div id = "deliveryHistory">

                </div>
                <?php } else {?>
                    <div id="errorMessage">
                        Không được cho phép
                    </div>
                <?php } ?>  
                </div>
                
            </div>
        </div>
    </div>

        <script src="js/script.js"></script>
        
    </div>
</body>

</html>