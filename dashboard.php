<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
    }

    $user = $_SESSION['user'];

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - He Thong Quan Ly Kho</title>

    <link rel="stylesheet" href="css/login.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    />
  </head>

  <body>
    <div class="dashboard_sidebar">
      <h3 class="dashboard_logo">IMS</h3>
      <div class="dashboard_sidebar_user">
        <img src="images\user\DSCF1892.jpg" alt="User image." />
        <span>Trung Hieu</span>
      </div>
      <div class="dashboard_sidebar_menus">
        <ul class="dashboard_menu_lists">
          <li class="menuActive">
            <a href=""
              ><i class="fas fa-gauge"></i
              ><span class="menuText"> Dashboard</span></a
            >
          </li>
          <li>
            <a href=""
              ><i class="fas fa-gauge"></i
              ><span class="menuText"> Dashboard</span></a
            >
          </li>
        </ul>
      </div>
    </div>
    <div class="dashboard_content_container">
      <div class="dashboard_topNav">
        <a href=""><i class="fas fa-bars"></i></a>
        <a href="" id="logoutBtn"><i class="fas fa-power-off"></i> Đăng xuất</a>
      </div>
      <div class="dashboard_content">
        <div class="dashboard_content_main"></div>
      </div>
    </div>
    <script>
      var ToggleBtn = document.querySelector(".dashboard_topNav a");
      var dashboard_sidebar = document.querySelector(".dashboard_sidebar");
      var dashboard_content_container = document.querySelector(
        ".dashboard_content_container"
      );
      var dashboard_logo = document.querySelector(".dashboard_logo");
      var userImage = document.querySelector(".dashboard_sidebar_user img");

      var sidebarIsOpen = true;

      ToggleBtn.addEventListener("click", (event) => {
        event.preventDefault();

        if (sidebarIsOpen) {
          dashboard_sidebar.style.width = "10%";
          dashboard_sidebar.style.transition = "0.5s all";
          dashboard_content_container.style.width = "90%";
          dashboard_logo.style.fontSize = "60px";
          userImage.style.width = "60px";

          var menuIcons = document.getElementsByClassName("menuText");
          for (var i = 0; i < menuIcons.length; i++) {
            menuIcons[i].style.display = "none";
          }

          document.getElementsByClassName(
            "dashboard_menu_lists"
          )[0].style.textAlign = "center";
          sidebarIsOpen = false;
        } else {
          dashboard_sidebar.style.width = "20%";
          dashboard_content_container.style.width = "80%";
          dashboard_logo.style.fontSize = "80%";
          userImage.style.width = "80px";

          var menuIcons = document.getElementsByClassName("menuText");
          for (var i = 0; i < menuIcons.length; i++) {
            menuIcons[i].style.display = "inline-block";
          }

          document.getElementsByClassName(
            "dashboard_menu_lists"
          )[0].style.textAlign = "left";
          sidebarIsOpen = true;
        }
      });
    </script>
  </body>
</html>
