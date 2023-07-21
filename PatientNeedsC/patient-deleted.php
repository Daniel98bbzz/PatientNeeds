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

$patient_id = $_GET['id'];
if(isset($_GET['save_changes'])) {
  $patient_initials = mysqli_real_escape_string($connection, $_GET['patient_initials']);
  $patient_gender = mysqli_real_escape_string($connection, $_GET['patient_gender']);
  $patient_risk = mysqli_real_escape_string($connection, $_GET['patient_risk']);
  $patient_age = mysqli_real_escape_string($connection, $_GET['patient_age']);
  $patient_department = mysqli_real_escape_string($connection, $_GET['patient_department']);
  $patient_room = mysqli_real_escape_string($connection, $_GET['patient_room']);
  $patient_bed = mysqli_real_escape_string($connection, $_GET['patient_bed']);


    $query = "UPDATE tbl_228_patients_history SET 
                patient_initials = '$patient_initials',
                patient_gender = '$patient_gender',
                patient_risk = '$patient_risk',
                patient_age = '$patient_age',
                patient_department = '$patient_department',
                patient_room = '$patient_room',
                patient_bed = '$patient_bed'
              WHERE patient_id = '$patient_id'";

    $result = mysqli_query($connection, $query);
    if(!$result){
        die("Update query failed: " . mysqli_error($connection));
    }

    header("Location: patient.php?id=".$patient_id);
    exit();
}

$query = "SELECT * FROM tbl_228_patients_history WHERE patient_id = '$patient_id'";
$result = mysqli_query($connection, $query);

if($result) {
    $patient = mysqli_fetch_assoc($result);
} else {
    die('DB query failed.');
}

$user_id = '315255836';
$user_info = "SELECT * FROM tbl_228_users WHERE user_r_id='{$user_id}'";
$getUserInfo = mysqli_query($connection, $user_info);
$user = mysqli_fetch_assoc($getUserInfo);

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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <title>Deleted Patient Details</title>
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
            <li class = "active">
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
      <h1 class=headlines>Deleted Patient Profile</h1>
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
      <div class="info-card light-card max-width-card centered-card">
    <div class="info-card-header">Deleted Patient Details</div>
    <form id="editForm" method="GET" action="patient-deleted.php">
        <input type="hidden" name="id" value="<?php echo $patient_id; ?>">
        <input type="hidden" name="save_changes" value="true">
        <div class="info-card-body">
            <h5 class="info-card-title"><?php echo $patient['patient_firstname'] . ' ' . $patient['patient_lastname']; ?></h5>
            <div class="info-card-text grid">
                <div><strong>ID:</strong> <?php echo $patient['patient_id']; ?></div>
                <div><strong>Initials:</strong> <span id="initials"><?php echo $patient['patient_initials']; ?></span></div>
                <div><strong>Gender:</strong> <span id="gender"><?php echo $patient['patient_gender']; ?></span></div>
                <div><strong>Risk Level:</strong> <span id="risk"><?php echo $patient['patient_risk']; ?></span></div>
                <div><strong>Age:</strong> <span id="age"><?php echo $patient['patient_age']; ?></span></div>
                <div><strong>Department:</strong> <span id="department"><?php echo $patient['patient_department']; ?></span></div>
                <div><strong>Room:</strong> <span id="room"><?php echo $patient['patient_room']; ?></span></div>
                <div><strong>Bed:</strong> <span id="bed"><?php echo $patient['patient_bed']; ?></span></div>
            </div>
            <div class = "buttonsContainer">
            <button id="editButtonDis" type="button" disabled>Edit Details</button>
            <button id="saveButtonDis" type="submit" style="display: none;" disabled>Save Changes</button>
            <button type='button' class="delete-pat-rem" disabled>Delete Patient</button>
            </div>
        </div>
    </form>
</div>
        </nav>
      </div>
    </main>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/delete_patient.js"></script>
  <script src="js/script.js"></script>
</body>

</html>