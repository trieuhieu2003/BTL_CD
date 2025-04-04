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
                    <figure class="highcharts-figure">
                        <div id="container"></div>
                            <p class="highcharts-description">
                                Pie charts are very popular for showing a compact overview of a
                                composition or comparison. While they can be harder to read than
                                column charts, they remain a popular choice for small datasets.
                            </p>
                    </figure>
                    </div>
                    <div class="col50">
                    <figure class="highcharts-figure">
                        <div id="containerBarChart"></div>
                            <p class="highcharts-description">
                                Pie charts are very popular for showing a compact overview of a
                                composition or comparison. While they can be harder to read than
                                column charts, they remain a popular choice for small datasets.
                            </p>
                    </figure>
                    </div>
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
        <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    var graphData = <?= json_encode($results) ?>;
    
    Highcharts.chart('container', {
    chart: {
        type: 'pie'
    },
    title: {
        text: 'Trạng thái đơn hàng'
    },
    tooltip: {
        pointFormatter: function () {
            var point = this;
            series = point.series;
            return '<b>${point.name}</b>: ${point.y}';
        }
    },
    subtitle: {
        text:
        'Source:<a href="https://www.mdpi.com/2072-6643/11/3/684/htm" target="_default">MDPI</a>'
    },
    plotOptions: {
        series: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: [{
                enabled: true,
                distance: 20
                

            }, {
                enabled: true,
                distance: -40,
                format: '{point.percentage:.1f}%',
                style: {
                    fontSize: '1.2em',
                    textOutline: 'none',
                    opacity: 0.7
                },
                filter: {
                    operator: '>',
                    property: 'percentage',
                    value: 10
                }
            }]
        }
    },
    series: [
        {
            name: 'Trạng thái',
            colorByPoint: true,
            data: $graphData
        }
    ]
});
var barGraphData = <?= json_encode($bar_chart_data) ?>;
var barGraphCategories = <?= json_encode($categories) ?>;

Highcharts.chart('containerBarChart', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Số lượng sản phẩm giao cho nhà cung cấp '
    },
    
    xAxis: {
        categories: barGraphCategories,
        crosshair: true,
        accessibility: {
            description: 'Countries'
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: ' Số lượng sản phẩm'
        }
    },
    tooltip: {
        valueSuffix: ' (1000 MT)',
        pointFormatter: function () {
            var point = this;
            series = point.series;
            return '<b>${point.name}</b>: ${point.y}';
        }
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [
        {
            name: 'suppliers',
            data: barGraphData,
        },
        
    ]
});


var lineCategories = <?= json_encode($line_categories) ?>;
var lineData = <?= json_encode($line_data) ?>;
Highcharts.chart('deliveryHistory', {
    chart: {
        type:'spline'
    },
title: {
    text: 'Lịch sử giao hàng mỗi ngày',
    align: 'left'
},


yAxis: {
    title: {
        text: 'Số lượng giao hàng'
    }
},

xAxis: {
    categories: lineCategories,
},

legend: {
    layout: 'vertical',
    align: 'right',
    verticalAlign: 'middle'
},

plotOptions: {
    series: {
        label: {
            connectorAllowed: false
        },
        pointStart: 2010
    }
},

series: [{
    name: 'Số lượng giao hàng',
    data: lineData,
},],

responsive: {
    rules: [{
        condition: {
            maxWidth: 500
        },
        chartOptions: {
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom'
            }
        }
    }]
}

});


</script>
    </div>
</body>

</html>