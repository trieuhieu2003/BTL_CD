<?php
    session_start();
    if (isset($_SESSION['user'])) header('location: login.php');
        $_SESSION['table'] = 'users';
        $user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">    
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard - Inventory Management System</title>
        <link rel="stylesheet" href="css/login.css" type=" text/css">
        <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
    </head>
    <body>
        <div id="dashboardMainContainer">
            <?php include 'partials/app-sidebar.php'; ?>
            
        </div>

<script src="js/script.js"></script>
<script src="js/jquery/jquery-3.7.1.min.js"></script>
<script>

    function  script(){

        this.initialize = function(){
            this.registerEvents();
        },

        this.registerEvents = function(){
            document.addEventListener('click', function(e){
                targetElement = e.target;
                classList = targetElement.classList;
                
                classlíst = e.target.classList;
                if(classList.contains('deleteUser')){
                    
                    e.preventDefault();
                    userId = targetElement.dataset.userid;
                    fname = targetElement.dataset.fname;
                    lname = targetElement.dataset.lname;

                    if(window.confirm('Bạn có muốn xoá không '+ fullName +'?')){
                        $.ajax({
                            method: 'POST',
                            data: {
                                user_id: userId
                            },
                            url: 'database/delete-user.php'
                        })
                    }else{
                        console.log('Không xoá')
                    }
                }
                
            });
        }
    }
</script>
    </body>