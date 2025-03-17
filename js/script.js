// Lấy các phần tử cần thiết trong DOM
var ToggleBtn = document.querySelector('.dashboard_topNav a'); // Nút toggle để mở/đóng sidebar
var dashboard_sidebar = document.querySelector('.dashboard_sidebar'); // Sidebar
var dashboard_content_container = document.querySelector('.dashboard_content_container'); // Container nội dung chính
var dashboard_logo = document.querySelector('.dashboard_logo'); // Logo trên sidebar
var userImage = document.querySelector('.dashboard_sidebar_user img'); // Ảnh người dùng trong sidebar

var sidebarIsOpen = true; // Biến trạng thái để kiểm tra xem sidebar có đang mở hay không

// Lắng nghe sự kiện click trên nút toggle
ToggleBtn.addEventListener('click', (event) => {
    event.preventDefault(); // Ngừng hành động mặc định của thẻ <a> khi click

    if (sidebarIsOpen) { // Nếu sidebar đang mở
        dashboard_sidebar.style.width = '10%'; // Giảm độ rộng sidebar xuống 10%
        dashboard_sidebar.style.transition = '0.5s all'; // Thêm hiệu ứng chuyển tiếp 0.5s
        dashboard_content_container.style.width = '90%'; // Mở rộng nội dung chính chiếm 90% chiều rộng
        dashboard_logo.style.fontSize = '60px'; // Giảm kích thước logo
        userImage.style.width = '60px'; // Giảm kích thước ảnh người dùng

        // Ẩn các văn bản trong menu
        var menuIcons = document.getElementsByClassName('menuText');
        for (var i = 0; i < menuIcons.length; i++) {
            menuIcons[i].style.display = 'none'; // Ẩn các mục văn bản của menu
        }

        // Căn giữa các danh sách menu
        document.getElementsByClassName('dashboard_menu_lists')[0].style.textAlign = 'center';
        sidebarIsOpen = false; // Đánh dấu sidebar đang đóng
    } else { // Nếu sidebar đang đóng
        dashboard_sidebar.style.width = '20%'; // Mở rộng độ rộng sidebar lại 20%
        dashboard_content_container.style.width = '80%'; // Thu hẹp nội dung chính xuống 80%
        dashboard_logo.style.fontSize = '80px'; // Đặt kích thước logo trở lại ban đầu
        userImage.style.width = '80px'; // Đặt kích thước ảnh người dùng trở lại ban đầu

        // Hiển thị lại các mục văn bản của menu
        var menuIcons = document.getElementsByClassName('menuText');
        for (var i = 0; i < menuIcons.length; i++) {
            menuIcons[i].style.display = 'inline-block'; // Hiển thị các mục văn bản của menu
        }

        // Căn trái các danh sách menu
        document.getElementsByClassName('dashboard_menu_lists')[0].style.textAlign = 'left';
        sidebarIsOpen = true; // Đánh dấu sidebar đang mở
    }
});

// Lắng nghe sự kiện click trên tài liệu để xử lý việc hiển thị hoặc ẩn các submenu
document.addEventListener('click', function(e) {
    let clickedElement = e.target; // Lấy phần tử được nhấp vào

    if(clickedElement.classList.contains('showHideSubMenu')) { // Nếu phần tử có lớp showHideSubMenu
        let subMenu = clickedElement.closest('li').querySelector('.subMenus'); // Tìm submenu gần nhất
        let mainMenuIcon = clickedElement.closest('li').querySelector('.mainMenuIconArrow'); // Tìm biểu tượng mũi tên của menu chính

        // Ẩn tất cả các submenu khác
        let subMenus = document.querySelectorAll('.subMenus');
        subMenus.forEach((sub) => {
            if(subMenu !== sub) 
            sub.style.display = 'none'; // Ẩn các submenu khác
        });

        // Hiển thị hoặc ẩn submenu hiện tại
        showHideSubMenu(subMenu, mainMenuIcon); 
    }
});

// Hàm hiển thị hoặc ẩn submenu
function showHideSubMenu(subMenu, mainMenuIcon) {  
    if(subMenu !== null) { // Nếu submenu tồn tại
        if(subMenu.style.display === 'block') { // Nếu submenu đang hiển thị
            subMenu.style.display = 'none'; // Ẩn submenu
            mainMenuIcon.classList.remove('fa-angle-down'); // Thay đổi mũi tên thành hướng trái
            mainMenuIcon.classList.add('fa-angle-left');
        } else { 
            subMenu.style.display = 'block'; // Hiển thị submenu
            mainMenuIcon.classList.remove('fa-angle-left'); // Thay đổi mũi tên thành hướng xuống
            mainMenuIcon.classList.add('fa-angle-down');
        }
    }
}

//Phần xử lý để đánh dấu menu/submenu hiện tại là "active" (được chọn)
let pathArray = window.location.pathname.split('/'); // Lấy đường dẫn hiện tại
let curFile = pathArray[pathArray.length - 1]; // Lấy tên file hiện tại từ URL
let curNav = document.querySelector('a[href="./' + curFile + '"]'); // Tìm phần tử <a> có href trùng với file hiện tại
curNav.classList.add('subMenuActive'); // Thêm lớp 'subMenuActive' cho menu con hiện tại
let mainNav = curNav.closest('li.liMainMenu'); // Tìm phần tử <li> cha chứa menu chính
mainNav.style.backgroundColor = '#f685a1'; // Đổi màu nền của menu chính đã chọn

let subMenu = curNav.closest('.subMenus'); // Tìm submenu chứa menu đã chọn
let mainMenuIcon = mainNav.querySelector('i.mainMenuIconArrow'); // Tìm biểu tượng mũi tên của menu chính

// Gọi hàm để hiển thị hoặc ẩn submenu nếu menu hiện tại thuộc submenu
showHideSubMenu(subMenu, mainMenuIcon);
