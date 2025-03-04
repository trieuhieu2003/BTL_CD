<div class="dashboard_sidebar" id="dashboard_sidebar">
    <h3 class="dashboard_logo" id="dashboard_logo">IMS</h3>
    <div class="dashboard_sidebar_user">
        <img src="images\user\DSCF1892.jpg" alt="User image." id="userImage" />
        <span><?= $user['first_name'] . ' ' . $user['last_name'] ?></span>
    </div>
    <div class="dashboard_sidebar_menus">
        <ul class="dashboard_menu_lists">
            <li class="menuActive">
                <a href="./dashboard.php"><i class="fas fa-dashboard"></i><span class="menuText"> Dashboard</span></a>
            </li>
            <li>
                <a href=""><i class="fas fa-gauge"></i><span class="menuText"> Dashboard</span></a>
            </li>
            <li>
                <a href=""><i class="fas fa-gauge"></i><span class="menuText"> Dashboard</span></a>
            </li>
            <li>
                <a href=""><i class="fas fa-gauge"></i><span class="menuText"> Dashboard</span></a>
            </li>
            <li>
                <a href="./user_add.php"><i class="fas fa-user-plus"></i><span class="menuText"> Add User</span></a>
            </li>
        </ul>
    </div>
</div>