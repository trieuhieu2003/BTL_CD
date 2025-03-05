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
                <a href="#"><i class="fas fa-gauge"></i><span class="menuText"> Product Management</span></a>
            </li>
            <li class="liMainMenu">
                <a href="#"><i class="fas fa-gauge">
                    </i><span class="menuText"> Supplier Management</span>
                </a>
            </li>
            <li class="liMainMenu">
                <a href="./user_add.php">
                    <i class="fas fa-user-plus"></i>
                    <span class="menuText"> User Management </span>
                    <i class="fas fa-angle-left mainMenuIconArrow"></i>

                </a>
                <ul class="subMenus">
                    <li><a class="subMenuLink" href=""><i class="fas fa-circle"></i>view users</a></li>
                    <li><a class="subMenuLink" href=""><i class="fas fa-circle"></i>add user</a></li>
                </ul>
            </li>

        </ul>
    </div>
</div>