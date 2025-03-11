<?php
session_start();

if (!isset($_SESSION['user']))
    header('location: login.php');
$_SESSION['table'] = 'products';

$products = include('database/show.php');


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product View - He Thong Quan Ly Kho</title>

    <link rel="stylesheet" href="css/user_add.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"
        integrity="sha512-b+nQTCdtTBIRIbraqNEwsjB6UvL3UEMkXnhzd8awtCYh0Kcsjl9uEgwVFVbhoj3uu1DO1ZMacNvLoyJJiNfcvg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/css/bootstrap-dialog.min.css"
        integrity="sha512-PvZCtvQ6xGBLWHcXnyHD67NTP+a+bNrToMsIdX/NUqhw+npjLDhlMZ/PhSHZN4s9NdmuumcxKHQqbHlGVqc8ow=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div id="dashboardMainContainer">
        <?php include('partials/app_slidebar.php') ?>
        <div class="dashboard_content_container">
            <?php include('partials/app_topnav.php') ?>
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <div class="row">
                        <div class="column column-12">
                            <h1 class="section_header"><i class="fa fa-list"></i> Danh sách sản phẩm</h1>
                            <div class="section_content">
                                <div class="users">

                                    <table>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Ảnh</th>
                                                <th>Tên sản phẩm</th>
                                                <th>Mô tả</th>
                                                <th>Tạo bởi</th>
                                                <th>Ngày cập nhật</th>
                                                <th>Hoạt động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($products as $index => $products) { ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td class="firstName">
                                                        <img class="productImages" src="uploads/products/<?= $products['img'] ?>" alt="" />
                                                    </td>
                                                    <td class="LastName"><?= $products['product_name'] ?></td>
                                                    <td class="email"><?= $products['description'] ?></td>
                                                    <td ><?= $products['created_by'] ?></td>
                                                    <td><?= date('M d,Y @ h:i:s A', strtotime($products['created_at'])) ?></td>
                                                    <td><?= date('M d,Y @ h:i:s A', strtotime($products['updated_at'])) ?></td>

                                                    <td>
                                                        <a href="" class="updateProduct" data-pid="<?= $products['id'] ?>"><i
                                                                class="fa fa-pencil"></i>Sửa</a>
                                                        <a href="" class="deleteProduct" data-name="<?= $products['product_name'] ?>" data-pid="<?= $products['id'] ?>"><i
                                                                class="fa fa-trash"></i>Xoá</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                    <p class="userCount"><?= count($products) ?> Sản phẩm</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    


    <script src="js/script.js">
    </script>
    <script src="js/jquery/jquery-3.7.1.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
        integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/js/bootstrap-dialog.js"
        integrity="sha512-AZ+KX5NScHcQKWBfRXlCtb+ckjKYLO1i10faHLPXtGacz34rhXU8KM4t77XXG/Oy9961AeLqB/5o0KTJfy2WiA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
    </script>
    <script>
    function Script() {  // Đặt tên hàm với chữ cái đầu in hoa (theo quy tắc PascalCase)
        this.registerEvents = function () {

            document.addEventListener('click', function(e) {
                        targetElement = e.target; //target element is the element that triggered the event
                        classList = targetElement.classList;

                        

                        if (classList.contains('deleteProduct')) {

                            e.preventDefault();
                            pId = targetElement.dataset.pid;
                            pName = targetElement.dataset.name;

                            
                            

                            if (window.confirm('Bạn có muốn xoá ' + pName + ' không?')) {
                            
                                $.ajax({
                                    method: 'POST',
                                    data: {
                                        id : pId,
                                        table : 'products'
                                    },
                                    url: 'database/delete.php',
                                    dataType: 'json',
                                    success: function(data) {
                                        if (data.success) {
                                            if (window.confirm(data.message)) {
                                                location.reload();
                                            }
                                        } else window.alert(data.message);
                                    }
                                })

                            }
                        }

                    
                    });
        }
        
        this.initialize = function () {
            this.registerEvents();
            
        }
    }

    var myScript = new Script();  // Tạo một đối tượng từ constructor
    myScript.initialize();  // Gọi phương thức từ đối tượng
</script>
</body>

</html>