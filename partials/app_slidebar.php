<?php
$user = $_SESSION['user'];
?>
<div class="dashboard_sidebar" id="dashboard_sidebar">
    <h3 class="dashboard_logo" id="dashboard_logo">IMS</h3>
    <div class="dashboard_sidebar_user">
        <img src="images\user\DSCF1892.jpg" alt="User image." id="userImage" />
        <span><?= $user['first_name'] . ' ' . $user['last_name'] ?></span>
    </div>
    <div class="dashboard_sidebar_menus">
        <ul class="dashboard_menu_lists">
            <!-- class="menuActive" -->
            <li class="liMainMenu">
                <a href="./dashboard.php"><i class="fas fa-dashboard"></i><span class="menuText"> Dashboard</span></a>
            </li>
            <li class="liMainMenu">
                <a href="javascript:void(0);" class="showHideSubMenu">
                    <i class="fas fa-tag showHideSubMenu"></i>
                    <span class="menuText showHideSubMenu"> Sản Phẩm </span>
                    <i class="fas fa-angle-left mainMenuIconArrow showHideSubMenu"></i>
                </a>

                <ul class="subMenus" id="user">
<<<<<<< HEAD
                    <li><a class="subMenuLink" href="./product-view.php"><i class="fas fa-circle"></i>view Product</a></li>
                    <li><a class="subMenuLink" href="./product-add.php"><i class="fas fa-circle"></i>add Product</a></li>
                    <li><a class="subMenuLink" href="./product-order.php"><i class="fas fa-circle"></i>Order Product</a></li>
=======
                    <li><a class="subMenuLink" href="./product-view.php"><i class="fas fa-circle"></i>Quản Lý Sản Phẩm</a></li>
                    <li><a class="subMenuLink" href="./product-add.php"><i class="fas fa-circle"></i>Thêm Sản Phẩm</a></li>
>>>>>>> Trung_Tan
                </ul>
            </li>
            <li class="liMainMenu">
                <a href="javascript:void(0);" class="showHideSubMenu">
                    <i class="fas fa-truck showHideSubMenu"></i>
                    <span class="menuText showHideSubMenu"> Nhà Cung Cấp </span>
                    <i class="fas fa-angle-left mainMenuIconArrow showHideSubMenu"></i>
                </a>

                <ul class="subMenus" id="user">
<<<<<<< HEAD
                    <li><a class="subMenuLink" href=""><i class="fas fa-circle"></i>Quản Lý Nhà Cung Cấp</a></li>
                    <li><a class="subMenuLink" href=""><i class="fas fa-circle"></i>Thêm Nhà Cung Cấp</a></li>
                </ul>
            </li>
            <li class="liMainMenu">
                <a href="javascript:void(0);" class="showHideSubMenu">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="menuText showHideSubMenu">Đơn Hàng</span>
                    <i class="fas fa-angle-left mainMenuIconArrow showHideSubMenu"></i>
                </a>
                
                <ul class="subMenus" id="user">
                    <li><a class="subMenuLink" href="./view-order.php"><i class="fas fa-circle"></i>Quản Lý Đơn Hàng</a></li>
                    <li><a class="subMenuLink" href="./product-order.php"><i class="fas fa-circle"></i>Tạo Đơn Hàng</a></li>
=======
                    <li><a class="subMenuLink" href="./supplier-view.php"><i class="fas fa-circle"></i>view Supplier</a></li>
                    <li><a class="subMenuLink" href="./supplier-add.php"><i class="fas fa-circle"></i>add Supplier</a></li>
>>>>>>> 7eb623cd54bb1ac130a06a7ebacea0a8ff249dea
                </ul>
            </li>
            <li class="liMainMenu showHideSubMenu">
                <a href="javascript:void(0);" class="showHideSubMenu">
                    <i class="fas fa-user-plus showHideSubMenu"></i>
                    <span class="menuText showHideSubMenu"> Người Dùng </span>
                    <i class="fas fa-angle-left mainMenuIconArrow showHideSubMenu"></i>
                </a>

                <ul class="subMenus" id="user">
                    <li><a class="subMenuLink" href="./users_view.php"><i class="fas fa-circle"></i>Quản Lý Người Dùng</a></li>
                    <li><a class="subMenuLink" href="./user_add.php"><i class="fas fa-circle"></i>Thêm Người Dùng</a></li>
                </ul>
            </li>

        </ul>

    </div>
</div>