<?php>
  // start session
  session_start();

    $error_message = '';
  if($_POST){
    include('database/connection.php');
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $query = 'SELECT * FROM users WHERE users.email= "'.$username.'" AND users.password= "'.$password.'"';
    $stmt = $conn->prepare($query);
    $result = $stmt->execute();
    
    
    if($stmt -> rowCount() > 0){
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $user = $stmt->fetchAll()[0];
      $_SESSION['user'] = $user;

      header('Location: dashboard.php');
    }else{
      $error_message = 'Tên đăng nhập hoặc mật khẩu không đúng';
    }
    
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Quản lý kho</title>
    <link rel="stylesheet" href="css/login.css" />
  </head>
  <body id="loginBody">
    <?php if(!empty($error_message)): {?>
      <div id="error_message">
        <strong>Error:</strong> <p><?= $error_message ?></p>
      </div>
    <?php }; ?> 
    <div class="container">
      <div class="loginHeader">
        <h1>Đăng nhập</h1>
        <p>Quản lý kho</p>
      </div>
        <div class="loginBody">
          <form action="">
            <div class="loginInputContainer">
            <label for="username">Tên đăng nhập</label>
              <input type="text" id="username" name="username" placeholder="Tên đăng nhập"/>
            </div>
            <div class="loginInputContainer">
              <label for="password">Mật khẩu</label>
              <input type="password" id="password" name="password" placeholder="Mật khẩu" />
            </div>
            <div class="loginInputContainer">
              <button type="submit">Đăng nhập</button>
            </div>
          </form>
          
        </div>
      </div>
    </div>
  </body>
</html>
