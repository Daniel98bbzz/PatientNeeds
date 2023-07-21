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
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $firstname = array_key_exists('firstName', $_GET) ? mysqli_real_escape_string($connection, $_GET['firstName']) : null;
    $lastname = array_key_exists('lastName', $_GET) ? mysqli_real_escape_string($connection, $_GET['lastName']) : null;
    $id = array_key_exists('id', $_GET) ? mysqli_real_escape_string($connection, $_GET['id']) : null;
    $gender = array_key_exists('gender', $_GET) ? mysqli_real_escape_string($connection, $_GET['gender']) : null;
    $risk = array_key_exists('risk', $_GET) ? mysqli_real_escape_string($connection, $_GET['risk']) : null;
    $department = array_key_exists('department', $_GET) ? mysqli_real_escape_string($connection, $_GET['department']) : null;
    $age = array_key_exists('age', $_GET) ? mysqli_real_escape_string($connection, $_GET['age']) : null;
    $room = array_key_exists('roomNum', $_GET) && !empty($_GET['roomNum']) ? "'".mysqli_real_escape_string($connection, $_GET['roomNum'])."'" : 'NULL';
    $bed = array_key_exists('bedNum', $_GET) && !empty($_GET['bedNum']) ? "'".mysqli_real_escape_string($connection, $_GET['bedNum'])."'" : 'NULL';
    if ($firstname && $lastname && $id && $gender && $risk && $department && $age) {
        $query = "INSERT INTO tbl_228_patients (patient_firstname, patient_lastname, patient_id, patient_gender, patient_age, patient_risk, patient_department, patient_room, patient_bed) 
        VALUES ('$firstname', '$lastname', '$id', '$gender', '$age', '$risk', '$department', $room, $bed)";

        $result = mysqli_query($connection, $query);
        if($result) {
            echo "Data inserted successfully.";
        } else {
            echo "ERROR: Could not able to execute $query. " . mysqli_error($connection);
        }
    }
}
$user_id = '315255836';
$user_info = "SELECT * FROM tbl_228_users WHERE user_r_id='{$user_id}'";
$getUserInfo = mysqli_query($connection, $user_info);
$user = mysqli_fetch_assoc($getUserInfo);
mysqli_close($connection);
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
    <title>Add Patient</title>
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
            <a href="#"><img src="img/PNLogo.PNG" alt="Logo" class="logo" /></a>
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
          <ul>
          <a href = "user.php">
          <li class="galit-li">
            <img class="galit" src="img/CuteGalit.PNG" /><?php echo $user['user_name'];?>
            <img class="galit-arrow" src="svg/caret-right-fill.svg" />
          </li>
        </a>
            <hr>
            <li>
              <img class="side-icons" src="svg/speedometer.svg"/>Dashboard
              <img class="arrow" src="svg/caret-right-fill.svg"/>
            </li>
            <hr />
            <a href = "active-patients.php"><li class="active">
              <img class="side-icons" src="svg/people-fill.svg"/>Active
              Patients<img class="arrow" src="svg/caret-right-fill.svg" />
            </li></a>
            <a href = "active-smart.php"><li>
                <img class="side-icons" src="svg/phone-vibrate-fill.svg" />Active Smart Calls<img
                class="arrow"
                src="svg/caret-right-fill.svg"
              >
            </li></a>
            <a href = "active-calls.php"><li>
              <img class="side-icons" src="svg/telephone-inbound-fill.svg">Active Voice Calls<img
              class="arrow"
              src="svg/caret-right-fill.svg"
            />
          </li></a>
              <hr />
              <a href = "history-smart.php"><li>
                <img class="side-icons" src="svg/clock-history.svg">Smart Call History<img
                class="arrow"
                src="svg/caret-right-fill.svg"
              />
            </li></a>
              <a href = "history-calls.php"><li>
                <img class="side-icons" src="svg/clock-history.svg">Voice Call History<img
                class="arrow"
                src="svg/caret-right-fill.svg"
              />
            </li></a>
              <a href = "history-patients.php"><li>
                <img class="side-icons" src="svg/clock-history.svg">Patient History<img
                class="arrow"
                src="svg/caret-right-fill.svg"
              />
            </li></a>
              <hr />
              <a href = "settings.php"><li>
                <img class="side-icons" src="svg/gear-fill.svg">Settings<img class="arrow" src="svg/caret-right-fill.svg" />
                </li></a>
                  <a href = "logout.php"><li><img class="side-icons" src="svg/box-arrow-in-right.svg">Logout<img class="arrow" src="svg/caret-right-fill.svg" /></li></a>
          </ul>
        </div>
      </nav>
      <main class="main-content">
        <h1>Add Patient</h1>
        <div class = "utilities">
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
          <div class = "bread">
            <p>Active Patients <img class = "ap-breadcrumb" src = "svg/caret-right-fill.svg">Add Patient</p>
          </div>
        <hr class = "head-hr"/>
        <div class="container">
            <div class=" text-center mt-5 ">
            </div>
        <div class="row ">               
            <div class="card mt-2 mx-auto p-4 bg-light">
                <div class="card-body bg-light">
                <div class = "container">
                <form id="contact-form" role="form" action="addPatient.php" method="GET">
                    <h4>Patient Information</h4>
                    <hr>
                <div class="controls">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form_name">Firstname*</label>
                                <input id="form_name" type="text" name="firstName" class="form-control" placeholder="Please Enter Firstname *" required="required" data-error="Firstname is required."> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form_lastname">Lastname*</label>
                                <input id="form_lastname" type="text" name="lastName" class="form-control" placeholder="Please Enter Lastname *" required="required" data-error="Lastname is required.">
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form_id">ID*</label>
                                <input id="form_id" pattern="[0-9]{8,9}" type="text" name="id" class="form-control" placeholder="Please Enter ID" required="required" data-error="ID is required.">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form_need">Gender*</label>
                                <select id="form_need" name="gender" class="form-control" required="required" data-error="Please specify your need.">
                                    <option value="" selected disabled>--Select--</option>
                                    <option >Women</option>
                                    <option >Men</option>
                                    <option >Other</option>
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form_need">Age*</label>
                                <input id="form_need" name="age" class="form-control" type="text" pattern = "^(0?[1-9]|[1-9][0-9])$" required="required" data-error="Please specify your need.">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form_need">Risk Level*</label>
                                <select id="form_need" name="risk" class="form-control" required="required" data-error="Please specify your need.">
                                    <option value="" selected disabled>--Select--</option>
                                    <option >Slight Risk</option>
                                    <option >Moderate Risk</option>
                                    <option >Enhanced Risk</option>
                                </select>
                                
                            </div>
                        </div>                        
                    </div>
                    <h4>Patient Location</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form_need">Department*</label>
                                <select id="form_need" name="department" class="form-control" required="required" data-error="Please specify your need.">
                                    <option value="" selected disabled>--Select--</option>
                                    <option >Pnimit A</option>
                                    <option >Pnimit B</option>
                                    <option >Pnimit C</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form_room">Room Number</label>
                                <input id="form_room" type="text" name="roomNum" class="form-control" placeholder="Please enter room number (numbers only)" pattern="[0-9]*">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form_room">Bed</label>
                                <input id="form_room" type="text" name="bedNum" class="form-control" placeholder="Please enter Bed number (numbers only)" pattern="[0-9]*">
                            </div>
                        </div>                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="form_message">Message</label>
                                <textarea id="form_message" name="message" class="form-control" placeholder="Write your message here." rows="4"  data-error="Please, leave us a message."></textarea>
                                </div>
                            </div>
                            <div class="form-group btn-container">
                                <input type="submit" class="btn btn-success btn-send pt-2 btn-block" value="Add Patient">
                                <button type="button" class="btn btn-secondary" onclick="showCancelWarning()">Cancel</button>
                            </div>
                            
                        <div id="cancelWarning" class="alert alert-warning d-none">
                            Are you sure you want to cancel the form?
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="cancelForm()">Yes</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="hideCancelWarning()">No</button>
                        </div>
                    </div>    
            </div>
             </form>
            </div>
                </div> 
        </div>
        </div>
    </div>
    </div>
      </main>
    </div>   
    <script src="js/script.js"></script> 
  </body>
</html>
