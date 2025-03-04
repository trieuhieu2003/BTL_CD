var ToggleBtn = document.querySelector('.dashboard_topNav a');
            var dashboard_sidebar = document.querySelector('.dashboard_sidebar');
            var dashboard_content_container = document.querySelector('.dashboard_content_container');
            var dashboard_logo = document.querySelector('.dashboard_logo');
            var userImage = document.querySelector('.dashboard_sidebar_user img');

            var sidebarIsOpen = true;

            ToggleBtn.addEventListener('click', (event) => {
                event.preventDefault();

                if (sidebarIsOpen) {
                    dashboard_sidebar.style.width = '10%';
                    dashboard_sidebar.style.transition = '0.5s all';
                    dashboard_content_container.style.width = '90%';
                    dashboard_logo.style.fontSize = '60px';
                    userImage.style.width = '60px';

                    var menuIcons = document.getElementsByClassName('menuText');
                    for (var i = 0; i < menuIcons.length; i++) {
                        menuIcons[i].style.display = 'none';
                    }

                    document.getElementsByClassName('dashboard_menu_lists')[0].style.textAlign = 'center';
                    sidebarIsOpen = false;
                } else {
                    dashboard_sidebar.style.width = '20%';
                    dashboard_content_container.style.width = '80%';
                    dashboard_logo.style.fontSize = '80px';
                    userImage.style.width = '80px';

                    var menuIcons = document.getElementsByClassName('menuText');
                    for (var i = 0; i < menuIcons.length; i++) {
                        menuIcons[i].style.display = 'inline-block';
                    }

                    document.getElementsByClassName('dashboard_menu_lists')[0].style.textAlign = 'left';
                    sidebarIsOpen = true;
                }
            });
