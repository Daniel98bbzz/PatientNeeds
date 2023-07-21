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
    <title>Patient History</title>
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
          <ul>
          <a href = "user.php">
          <li class="galit-li">
            <img class="galit" src="img/CuteGalit.PNG" /><?php echo $user['user_name'];?>
            <img class="galit-arrow" src="svg/caret-right-fill.svg" />
          </li>
        </a>
            <hr>
            <a href = "index.php"><li>
                <img class="side-icons" src="svg/speedometer.svg" />Dashboard
                <img class="arrow" src="svg/caret-right-fill.svg" />
              </li></a>
            <hr />
            <a href = "active-smart.php">
            <li>
              <img class="side-icons" src="svg/people-fill.svg" />Active
              Patients<img class="arrow" src="svg/caret-right-fill.svg" />
            </li>
            </a>
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
            <a href = "history-patients.php"><li class = "active">
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
        
      <!-- desktop area -->
      <div class="desktop-table">
        <h1>Patients History</h1>
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
        <hr class = "head-hr" />
        <div class = "">
            <div class = active-patients>
                <div class = "active-helpers">
                    <button type="button" class="btn btn-primary btn-sm">Select All</button>
                    <button type="button" class="btn btn-primary btn-sm">Mute All</button>
                    <button type="button" class="btn btn-primary btn-sm"> <a href="addPatient.php">Add Patient</a></button>
                    <form action="" method="GET">
                    <input class="search-bar" type="text" placeholder="Search Patients" name="search_term">
                    <button type="submit" class="btn btn-outline-primary">Search</button>
                    </form>
                    <div class = filter-box>
                        <img class = "filter" src = "svg/filter.svg">
                    </div>                 
                </div>               
                <table>             
                    <thead>
                      <tr>
                        <th>Patient</th>
                        <th>Gender</th>
                        <th>Initials</th>
                        <th>Age</th>
                        <th>Location</th>
                        <th>Risk</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query = "SELECT * FROM tbl_228_patients_history";
                        
                        if (isset($_GET['search_term'])) {
                          $searchTerm = mysqli_real_escape_string($connection, $_GET['search_term']);
                          $query .= " WHERE patient_firstname LIKE '%$searchTerm%' OR patient_lastname LIKE '%$searchTerm%' OR patient_initials LIKE '%$searchTerm%'";
                        }

                        $result = mysqli_query($connection, $query);

                        if (!$result) {
                          die("Query failed: " . mysqli_error($connection));
                        }

                        while ($row = mysqli_fetch_assoc($result)) {                     
                            echo "<tr>";
                            echo "<td><a href='patient-deleted.php?id=" . $row["patient_id"] . "'><img class='patient-card' src ='svg/person-vcard-fill.svg'></a></td>";
                            echo "<td><img class='gender' src = 'svg/gender-" . strtolower($row["patient_gender_desc"]) . ".svg'></td>";
                            echo "<td>" . $row["patient_initials"] . "</td>";
                            echo "<td>" . $row["patient_age"] . "</td>";
                            echo "<td>Room " . $row["patient_room"] . "</td>";
                            echo "<td><div class='risk-level " . strtolower($row["patient_risk_desc"]) . "-risk'>" . $row["patient_risk"] . "</div></td>";
                            echo "<div class = 'actions'>
                            <td>
                            <button type='button' class='btn btn-danger'>DELETED</button>
                            </td>
                          </div>";
                            echo "</tr>";
                        }
                        mysqli_free_result($result);
                        ?>
                    </tbody>
                  </table>
                  <nav aria-label="Page navigation example">
                    
                  </nav>
            </div>
        </div>
      </div>

        <!-- mobile area -->
      <div class="mobile-table-area" style="display:none;">
        <h2><img src="svg/arrow-left.svg">Patients History</h2>
        <div class="table-search-form">
          <h3>Search By</h3>
          <div class="select-box">
            <select id="form_need" name="need" class="form-control" required="required" data-error="Please specify your need.">
                <option value="" selected="" disabled=""></option>
                <option>Slight Risk</option>
                <option>Moderate Risk</option>
                <option>Enhanced Risk</option>
            </select>
          </div>
          <div class="filter-icon">
            <img src="svg/funnel-fill.svg" alt="">
          </div>
        </div>
        <table class="mobile-table">
          <tbody>
          <?php
                        $query = "SELECT * FROM tbl_228_patients_history";
                        $result = mysqli_query($connection, $query);

                        if (!$result) {
                            die("Query failed: " . mysqli_error($connection));
                        }

                        while ($row = mysqli_fetch_assoc($result)) {
                          echo "<tr>";
                          echo "<td><div class='status " . $row["patient_risk_desc"] . "'></div></td>"; 
                          echo "<td><div class='user-image'><img src='svg/person-lines-fill.svg' alt=''></div></td>";
                          echo "<td>";
                          echo "<div class='patients-name'>";
                          echo "<h3>" . $row["patient_firstname"] . " " . $row["patient_lastname"] . "</h3>"; 
                          echo "<div class='details'>";
                          echo "<div class='gender-area'>";
                          echo "<div class='gender-img'>";
                          echo "<img src='svg/genderm.svg' alt=''>"; 
                          echo "<span>" . ucfirst($row["patient_gender_desc"]) . "</span>"; 
                          echo "</div></div>";
                          echo "<div class='room-number'>";
                          echo "<div class='location-image'>";
                          echo "<img src='svg/geo-alt-fill.svg' alt=''>";
                          echo "</div>";
                          echo "<span>Room " . $row["patient_room"] . "</span>"; 
                          echo "</div></div></div>";
                          echo "<td><div class='more-area'><img src='svg/three-dots.svg' alt=''></div></td>";
                          echo "</tr>";
                      }
                        mysqli_free_result($result);
                        mysqli_close($connection);
                        ?>
          </tbody>
        </table>
        <nav aria-label="Page navigation example">
          
        </nav>
      </div>    
      </main>
    </div>   
    <script src = "js/script.js"></script>
  </body>
</html>
