<?php

include "config.php";
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if(mysqli_connect_errno()) {
    die("DB connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
}

$errorMessage = '';


if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['username']) && isset($_GET['password'])){
    $username = mysqli_real_escape_string($connection, $_GET['username']);
    $password = mysqli_real_escape_string($connection, $_GET['password']);

    $query = "SELECT * FROM tbl_228_users WHERE user_email='{$username}' AND user_password='{$password}'";
    $result = mysqli_query($connection, $query);
    if(mysqli_num_rows($result) == 1){
      session_start();
      $_SESSION['user_email'] = $username; // set user email in the session
      header('Location: index.php');
      exit;
  }

    
    $queryPatient = "SELECT * FROM tbl_228_patients WHERE patient_id='{$username}' AND '1'='{$password}'";
    $resultPatient = mysqli_query($connection, $queryPatient);
    if(mysqli_num_rows($resultPatient) == 1){
        session_start();
        $_SESSION['patient_id'] = $username;
        header('Location: patientInterface.php');
        exit;
    } else {
        $errorMessage = "Invalid Username or Password";
    }
}



mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Patient Needs - Login</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;700&display=swap" rel="stylesheet" />
  </head>
  <body class="login_body">
    <div class="login_center">
      <h1>Login</h1>
      <?php
      if(!empty($errorMessage)) {
          echo "<p style='color:red;'>$errorMessage</p>";
      }
      ?>
      <form class = "login-form" action = "login.php" method="get">
        <div class="login_txt_field">
          <input type="text" name="username" required>
          <span></span>
          <label>Username</label>
        </div>
        <div class="login_txt_field">
          <input type="password" name="password" required>
          <span></span>
          <label>Password</label>
        </div>
        <div class="login_pass">Forgot Password?</div>
        <input type="submit" value="Login" class="login_submit">
        <div class="login_signup_link">
        </div>
      </form>
    </div>
  </body>
</html>
