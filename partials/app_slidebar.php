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
                    <li><a class="subMenuLink" href="./product-view.php"><i class="fas fa-circle"></i>Quản Lý Sản Phẩm</a></li>
                    <li><a class="subMenuLink" href="./product-add.php"><i class="fas fa-circle"></i>Thêm Sản Phẩm</a></li>
                </ul>
            </li>
            <li class="liMainMenu">
                <a href="javascript:void(0);" class="showHideSubMenu">
                    <i class="fas fa-truck showHideSubMenu"></i>
                    <span class="menuText showHideSubMenu"> Nhà Cung Cấp </span>
                    <i class="fas fa-angle-left mainMenuIconArrow showHideSubMenu"></i>
                </a>

                <ul class="subMenus" id="user">
                    <li><a class="subMenuLink" href="./supplier-view.php"><i class="fas fa-circle"></i>Quản lý nhà cung cấp</a></li>
                    <li><a class="subMenuLink" href="./supplier-add.php"><i class="fas fa-circle"></i>Thêm Nhà Cung Cấp</a></li>
                </ul>
            </li>
            <li class="liMainMenu">
                <a href="javascript:void(0);" class="showHideSubMenu">
                    <i class="fas fa-shopping-cart showHideSubMenu"></i>
                    <span class="menuText showHideSubMenu">Quản Lý Đơn Hàng</span>
                    <i class="fas fa-angle-left mainMenuIconArrow showHideSubMenu"></i>
                </a>

                <ul class="subMenus" id="user">
                    <li><a class="subMenuLink" href="./view-order.php"><i class="fas fa-circle"></i>Quản lý đơn hàng</a></li>
                    <li><a class="subMenuLink" href="./product-order.php"><i class="fas fa-circle"></i>Thêm đơn hàng</a></li>
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