<?php
// start session
session_start();
if (isset($_SESSION["user"]) && isset($_SESSION["location: dashboard.php"])) {
  // Thực thi hành động nếu điều kiện đúng
}


$error_message = '';

if ($_POST) {
  include('database/connection.php');

  $username = $_POST['username'];
  $password = $_POST['password'];

//   $query = 'SELECT * FROM users WHERE users.email= "' . $username . '" AND users.password= "' . $password . '"';
//   $stmt = $conn->prepare($query);
//   $stmt->execute();


//   if ($stmt->rowCount() > 0) {
//     $stmt->setFetchMode(PDO::FETCH_ASSOC);
//     $user = $stmt->fetchAll()[0];
//     $_SESSION['user'] = $user;

//     header('Location: dashboard.php');
//   } else 
//     $error_message = 'Tên đăng nhập hoặc mật khẩu không đúng';
// }

$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);

$users = $stmt->fetchAll();

$user_exist = false;
foreach ($users as $user) {
    $upass = $user['password'];

    // So sánh trực tiếp không dùng password_verify()
    if ($password === $upass) {
        $user_exist = true;
        $user['permissions'] = explode(',', $user['permissions']);
        $_SESSION['user'] = $user;
        break;
    }
}
if ($user_exist) {
    header('Location: dashboard.php');
    exit();
} else {
    $error_message = 'Tên đăng nhập hoặc mật khẩu không đúng';
}}

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
  <?php if (!empty($error_message)) { ?>
    <div id="errorMessage">
      <strong>Error:</strong>
      </p><?= $error_message ?></p>
    </div>
  <?php } ?>
  <div class="container">
    <div class="loginHeader">
      <h1>IMS</h1>
      <p>HỆ THỐNG QUẢN LÝ KHO</p>
    </div>
    <div class="loginBody">
      <form action="login.php" method="POST">
        <div class="loginInputsContainer">
          <label for="username">Tên đăng nhập</label>
          <input type="text" id="username" name="username" placeholder="Tên đăng nhập" />
        </div>
        <div class="loginInputsContainer">
          <label for="password">Mật khẩu</label>
          <input type="password" id="password" name="password" placeholder="Mật khẩu" />
        </div>
        <div class="loginInputsContainer">
          <button type="submit">Đăng nhập</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>