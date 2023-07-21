<?php
session_start();
if(!isset($_SESSION['user_email'])){
    header('Location: login.php');
    exit;
}
include "config.php";

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if(mysqli_connect_errno()) {
    die("DB connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
}

$user_id = '315255836';
$query = "SELECT * FROM tbl_228_users WHERE user_r_id='{$user_id}'";
$result = mysqli_query($connection, $query);
$user = mysqli_fetch_assoc($result);
$user_image = $user['user_image'];

$edit_mode = isset($_GET['edit_mode']) ? $_GET['edit_mode'] : false;

if(isset($_GET['save_changes'])){
    $user_name = mysqli_real_escape_string($connection, $_GET['user_name']);
    $user_r_id = mysqli_real_escape_string($connection, $_GET['user_r_id']);
    $user_job = mysqli_real_escape_string($connection, $_GET['user_job']);

    if(isset($_GET['user_date'])) {
      $date = DateTime::createFromFormat('m/d/Y', $_GET['user_date']);
      $mysql_date = $date->format('Y-m-d');
      $mysql_date = mysqli_real_escape_string($connection, $mysql_date);
    } else {
        $mysql_date = date('Y-m-d');
    }

    $query = "UPDATE tbl_228_users SET 
                user_name = '{$user_name}', 
                user_r_id = '{$user_r_id}', 
                user_job = '{$user_job}', 
                user_date = '{$mysql_date}'
              WHERE user_r_id = '{$user_id}'";

    $result = mysqli_query($connection, $query);
    if(!$result){
        die("Update query failed" . mysqli_error($connection));
    }
    $edit_mode = false;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/styles.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;700&display=swap" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
  <title>User Profile Details</title>
</head>
<!--Presentors:
Daniel Buzaglo, Adi Abilevitch-->
<body>
  <div class="wrapper">
    <nav>
      <div class="mobile-navbar-area" style="display:none;">
        <div class="bar-icon" onclick="offcanvas();">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" stroke="#057ffc">
            <path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"/></svg>
        </div>
        <div class="mobile-logo">
          <a href="index.php"><img src="img/PNLogo.PNG" alt="Logo" class="logo" /></a>
        </div>
        <div class="mobile-utilities">
          <div class="utilities">
            <button type="button" class="icon-button">
              <span class="material-icons">
                tune
              </span>
            </button>
            <button type="button" class="icon-button2">
              <span class="material-icons">
                question_answer
              </span>
              <span class="icon-button__badge">28</span>
            </button>
            <button type="button" class="icon-button3">
              <span class="material-icons">notifications</span>
              <span class="icon-button__badge">14</span>
            </button>
          </div>
          <div class="modal-shadow" id="modal-shadow" onclick="remove();"></div>
        </div>
      </div>
      <div class="sidebar" id="sidebar">
        <div class="close-bar close-area" style="display: none;" onclick="remove();">
          <div class="close">
            <div class="close-icon"></div>
          </div>
        </div>
        <a href = "index.php"><img src="img/PNLogo.PNG" alt="Logo" class="logo"/></a>
        <header>
        </header>
        <ul>
        <a href = "user.php">
          <li class="galit-li active">
            <img class="galit" src="img/CuteGalit.PNG" /><?php echo $user['user_name'];?>
            <img class="galit-arrow" src="svg/caret-right-fill.svg" />
          </li>
        </a>
          <hr>
          <li>
            <img class="side-icons" src="svg/speedometer.svg" />Dashboard
            <img class="arrow" src="svg/caret-right-fill.svg" />
          </li>
          <hr />
          <a href="active-patients.php">
            <li>
              <img class="side-icons" src="svg/people-fill.svg" />Active
              Patients<img class="arrow" src="svg/caret-right-fill.svg" />
            </li>
          </a>
          <a href="active-smart.php">
            <li>
              <img class="side-icons" src="svg/phone-vibrate-fill.svg" />Active Smart Calls<img class="arrow"
                src="svg/caret-right-fill.svg">
            </li>
          </a>
          <a href="active-calls.php">
            <li>
              <img class="side-icons" src="svg/telephone-inbound-fill.svg">Active Voice Calls<img class="arrow"
                src="svg/caret-right-fill.svg" />
            </li>
          </a>
          <hr />
          <a href="history-smart.php">
            <li>
              <img class="side-icons" src="svg/clock-history.svg">Smart Call History<img class="arrow"
                src="svg/caret-right-fill.svg" />
            </li>
          </a>
          <a href="history-calls.php">
            <li>
              <img class="side-icons" src="svg/clock-history.svg">Voice Call History<img class="arrow"
                src="svg/caret-right-fill.svg" />
            </li>
          </a>
          <a href="history-patients.php">
            <li>
              <img class="side-icons" src="svg/clock-history.svg">Patient History<img class="arrow"
                src="svg/caret-right-fill.svg" />
            </li>
          </a>
          <hr />
          <a href="settings.php">
            <li>
              <img class="side-icons" src="svg/gear-fill.svg">Settings<img class="arrow"
                src="svg/caret-right-fill.svg" />
            </li>
          </a>
          <a href="logout.php">
            <li><img class="side-icons" src="svg/box-arrow-in-right.svg">Logout<img class="arrow"
                src="svg/caret-right-fill.svg" /></li>
          </a>
        </ul>
      </div>
    </nav>
    <main class="main-content">
      <h1 class=headlines>User Profile</h1>
      <div class="utilities">
        <button type="button" class="icon-button3">
          <span class="material-icons">notifications</span>
          <span class="icon-button__badge">14</span>
        </button>
        <button type="button" class="icon-button2">
          <span class="material-icons">
            question_answer
          </span>
          <span class="icon-button__badge">28</span>
        </button>
        <button type="button" class="icon-button">
          <span class="material-icons">
            tune
          </span>
        </button>
      </div>
      <hr class="head-hr" />
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
      
      <div class="container">
      <div class="row flex-lg-nowrap">
        <div class="col">
          <div class="row">
            <div class="col mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="e-profile">
                    <div class="row">
                      <div class="col-12 col-sm-auto mb-3">
                        <div class="mx-auto" style="width: 140px;">
                          <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px;">
                          <img class = "user_profile_pic" src = "<?php echo $user_image; ?>" alt = "user_image">
                          </div>
                        </div>
                      </div>
                      <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                        <div class="text-center text-sm-left mb-2 mb-sm-0">
                          <h4 class="galit-prof-name"><?php echo $user['user_name']; ?></h4>
                        </div>
                        <div class="text-center text-sm-right">
                          <span class="badge badge-secondary">administrator</span>
                        </div>
                      </div>
                    </div>     
                    <div class="nav nav-tabs">
                      <ul class="nav-item1">
                      <li class="nav-item"><h2>User Details</h2> </li>
                      </ul>
                    </div>
                    <div class="tab-content pt-3">
                      <div class="tab-pane active">
                          <form class="form" novalidate="" method="GET">
                              <div class="row">
                                  <div class="col">
                                      <div class="row">
                                          <div class="col">
                                              <div class="form-group">
                                                  <label>Full Name: 
                                                      <?php 
                                                      if($edit_mode) 
                                                          echo "<input type='text' name='user_name' value='{$user['user_name']}' />"; 
                                                      else 
                                                          echo $user['user_name']; 
                                                      ?>
                                                  </label>
                                              </div>
                                              <div class="form-group">
                                                  <label>ID: 
                                                      <?php 
                                                      if($edit_mode) 
                                                          echo "<input type='text' name='user_r_id' value='{$user['user_r_id']}' />"; 
                                                      else 
                                                          echo $user['user_r_id']; 
                                                      ?>
                                                  </label>
                                              </div>
                                          </div>
                                          <div class="col">
                                              <div class="form-group">
                                                  <label>Username: 
                                                      <?php 
                                                      /*if($edit_mode) 
                                                          echo "<input type='text' name='user_email' value='{$user['user_email']}' />";
                                                      else*/ 
                                                          echo $user['user_email']; 
                                                      ?>
                                                  </label>
                                              </div>
                                              <div class="form-group">
                                                  <label>Job: 
                                                      <?php 
                                                      if($edit_mode) 
                                                          echo "<input type='text' name='user_job' value='{$user['user_job']}' />"; 
                                                      else 
                                                          echo $user['user_job']; 
                                                      ?>
                                                  </label>
                                              </div>
                                              <div class="form-group">
                                                <label>Date: 
                                                    <?php 
                                                    if($edit_mode) 
                                                        echo "<input type='text' id='date-picker' name='user_date' value='" . date('m/d/Y', strtotime($user['user_date'])) . "' />"; 
                                                    else 
                                                        echo date('m/d/Y', strtotime($user['user_date'])); 
                                                    ?>
                                                </label>
                                            </div>
                                            <script>
                                              $(document).ready(function() {
                                                  <?php if($edit_mode) : ?>
                                                      $("#date-picker").datepicker({
                                                          dateFormat: "mm/dd/yy"
                                                      });
                                                  <?php endif; ?>
                                              });
                                            </script>
                                          </div>
                                      </div>
                                      <div class="row">                                          
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col d-flex justify-content-end">
                                      <button class="btn btn-primary" type="submit" name="save_changes">Save Changes</button>
                                      <?php
                                          if(!$edit_mode)
                                              echo '<button class="btn btn-secondary" type="submit" name="edit_mode" value="true">Edit Details</button>';
                                      ?>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
        </nav>
      </div>
    </main>
  </div>
  <script src="js/script.js"></script>
</body>
</html>