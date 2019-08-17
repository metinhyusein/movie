<?php

session_start();

require_once '../config/index.php';

function p($data) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";

};

$email = '';
$password = '';
$errors = [];
$userInfo = [];

if (isset($_POST['submit'])) {
    if (!mb_strlen($_POST['email'])) {
        $errors[] = 'Please enter your Email';
    }elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter valid Email';
    }else {
        $sql = "SELECT 
                 `id`
                FROM `".TABLE_USERS."`
                WHERE `email` = '".mysqli_real_escape_string($conn, $_POST['email'])."'
                ";
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result)) {
                $email = trim($_POST['email']);
            }
        }
    }

    if (!mb_strlen($_POST['password'])) {
        $errors[] = 'Please enter your password';
    }elseif (mb_strlen($_POST['password']) > 32  || mb_strlen($_POST['password']) < 8) {
        $errors[] = 'Your Password should be less than 32 symbols and more than 8 symbols';
    }else {
        $password = trim($_POST['password']);
    }

    if (!count($errors)) {
        $sql = " SELECT 
                `id`,
                `email`,
                `type`,
                `password`
                FROM `".TABLE_USERS."`
                WHERE `email` = '".mysqli_real_escape_string($conn, $email)."'
        

        ";

        if ($result = mysqli_query($conn, $sql)) {
            $userInfo = mysqli_fetch_assoc($result);
            p($userInfo);
        }

        if (is_array($userInfo) && count($userInfo)) {
            if ($userInfo['type'] !== 'admin') {
              $errors[] = 'You are not Admin';
            }elseif (!password_verify($password, $userInfo['password'])) {
              $errors[] = "Your password is incorrect";
            }else {
              unset($userInfo['password']);
              $_SESSION['user'] = $userInfo;
              header('location: index.php');
            }
        }else {
            $errors[] = "User does not exist";
        }
    }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin - Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form action="" method="POST">
          <div class="form-group">
            <div class="form-label-group">
              <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" autofocus="autofocus">
              <label for="inputEmail">Email address</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" >
              <label for="inputPassword">Password</label>
            </div>
          </div>
          <div class="form-group">
            <div class="checkbox">
              <label>
                <input type="checkbox" value="remember-me">
                Remember Password
              </label>
            </div>
          </div>
          <button type="submit" name="submit"  class="btn btn-primary btn-block">Login</button>
          
          <div class="alert alert-danger">
            <ul>
              <?php if(isset($errors) && count($errors)):?>
                <?php for ($i=0; $i < count($errors); $i++):?>
                  <li><?=$errors[$i]?></li>
                <?php endfor?>
              <?php endif?>
            </ul>
          </div>

        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="register.html">Register an Account</a>
          <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
