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

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/styles.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;700&display=swap" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <title>Settings</title>
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
          <li class="galit-li">
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
            <li class = "active">
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
      <!-- desktop area -->
    <div class="desktop-table">
        <h1>Settings</h1>
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
        <div class="settings-content">
            <div class="settings-content">
            <div class="settings-section">
              <h2>Change Password</h2>
              <form action="changePassword.php" method="GET">
                  <div class="form-group">
                      <label for="current-password">Current Password</label>
                      <input type="password" id="current-password" class="form-control" required>
                  </div>
                  <div class="form-group">
                      <input type="hidden" name="user-id" value="<?php echo $userId; ?>">
                  </div>
                  <div class="form-group">
                      <label for="confirm-password">Confirm New Password</label>
                      <input type="password" name="confirm-password" id="confirm-password" class="form-control" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Change Password</button>
              </form>
            </div>
                <div class="settings-section">
                  <h2>Update Email</h2>
                  <form>
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" id="email" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Email</button>
                  </form>
                </div>
              
                <div class="settings-section">
                  <h2>Notifications</h2>
                  <form>
                    <div class="form-check">
                      <input type="checkbox" id="email-notifications" class="form-check-input">
                      <label for="email-notifications" class="form-check-label">Email Notifications</label>
                    </div>
                    <div class="form-check">
                      <input type="checkbox" id="sms-notifications" class="form-check-input">
                      <label for="sms-notifications" class="form-check-label">SMS Notifications</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Notification Settings</button>
                  </form>
                </div>
              </div>
              
        </div>
    </div>

    </main>
  </div>

  <script src="js/script.js"></script>
</body>

</html>
