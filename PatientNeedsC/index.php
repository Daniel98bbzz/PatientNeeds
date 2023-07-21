<?php
session_start();
if(!isset($_SESSION['user_email'])){
    header('Location: login.php');
    exit;
}
include "config.php";

// connect to the database
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
  <title>Patient Needs</title>
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
          <li class="active">
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
      <h1 class=headlines>Dashboard</h1>
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
      <div class="boxes">
      <?php 
          $queryTotalCalls = "SELECT COUNT(*) as total FROM tbl_228_smartcalls WHERE DATE(smart_time) = CURDATE() - INTERVAL 1 DAY";
          $resultTotalCalls = mysqli_query($connection, $queryTotalCalls);
          
          $dataTotalCalls = mysqli_fetch_assoc($resultTotalCalls);
          $total_all_calls = $dataTotalCalls['total'];
        ?>
        <div class="card">
          <h4>Total Calls Last Day</h4>
          <h2><?php echo $total_all_calls; ?></h2>
        </div>
        <?php 
          $queryTotal = "SELECT COUNT(*) as total FROM tbl_228_smartcalls WHERE smart_type != 'Voice Call'";
          $resultTotal = mysqli_query($connection, $queryTotal);
          
          $data = mysqli_fetch_assoc($resultTotal);
          $total_calls = $data['total'];
        ?>
        <div class="card">
          <h4>Total Smart Calls</h4>
          <h2><?php echo $total_calls; ?></h2>
        </div>
        <?php 
          $queryTotalVoice = "SELECT COUNT(*) as total FROM tbl_228_smartcalls WHERE smart_type = 'Voice Call'";
          $resultTotalVoice = mysqli_query($connection, $queryTotalVoice);
          
          $dataVoice = mysqli_fetch_assoc($resultTotalVoice);
          $total_voice_calls = $dataVoice['total'];
        ?>
        <div class="card">
          <h4>Total Voice Calls</h4>
          <h2><?php echo $total_voice_calls; ?></h2>
        </div>
      </div>

      <div class="squares">
        <div class="card">
          <h3>Smart Call By Time Of Day</h3>
          <canvas id="myChart" style="width:100%;max-width:800px;height:600px;"></canvas>
        </div>
        <div class="card">
          <h3>Voice Call By Time Of Day</h3>
          <canvas id="myChart2" style="width:100%;max-width:800px;height:600px;"></canvas>
        </div>
        
      </div>
      
      <!-- desktop area -->
      <div class="desktop-table">
        <h2>Recent Active Smart Calls</h2>
        <table>
          <thead>
            <tr>
              <th>Patient</th>
              <th>Date & Time</th>
              <th>Type</th>
              <th>Initials</th>
              <th>Location</th>
              <th>Risk Level</th>
            </tr>
          </thead>
          <tbody>
          <?php
                        $query = "SELECT * FROM tbl_228_smartcalls ORDER BY smart_time DESC LIMIT 4";
                        
                        $result = mysqli_query($connection, $query);

                        if (!$result) {
                          die("Query failed: " . mysqli_error($connection));
                        }

                        while ($row = mysqli_fetch_assoc($result)) {
                            // each $row is a row from your table
                            echo "<tr>";
                            echo "<td><a href='patient.php?id=" . $row["patient_id"] . "'><img class='patient-card' src ='svg/person-vcard-fill.svg'></a></td>";
                            echo "<td>" . $row['smart_time'] . "</td>";
                            echo "<td>" . $row["smart_type"] . "</td>";
                            echo "<td>" . $row["smart_initials"] . "</td>";
                            echo "<td>Room " . $row["smart_room"] . "</td>";
                            echo "<td><div class='risk-level " . strtolower($row["smart_risk_desc"]) . "-risk'>" . $row["smart_risk"] . "</div></td>";
                            echo "</tr>";
                        }
                        mysqli_free_result($result);
                        ?>
          </tbody>
        </table>
      </div>

      <!-- mobile area -->
      <div class="mobile-table-area" style="display: none;">
        <h2>Recent Active Smart Calls</h2>
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
              $query = "SELECT * FROM tbl_228_smartcalls ORDER BY smart_time DESC LIMIT 4";

              $result = mysqli_query($connection, $query);

              if (!$result) {
                  die("Query failed: " . mysqli_error($connection));
              }

              while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td><div class='status " . $row['smart_risk_desc'] . "'></div></td>";
                  echo "<td><div class='user-image'><img src='svg/person-lines-fill.svg' alt=''></div></td>";
                  echo "<td>";
                  echo "<div class='patients-name'>";
                  echo "<h3>" . $row["smart_initials"] . "</h3>";  
                  echo "<div class='details'>";
                  echo "<div class='gender-area'>";
                  echo "<div class='gender-img'>";
                  echo "<img src='svg/gender-male.svg' alt=''>"; 
                  echo "</div></div>";
                  echo "<div class='room-number'>";
                  echo "<div class='location-image'>";
                  echo "<img src='svg/geo-alt-fill.svg' alt=''>";
                  echo "</div>";
                  echo "<span>Room " . $row["smart_room"] . "</span>";
                  echo "</div></div></div></td>";
                  echo "<td><div class='more-area'>
                        <img src='svg/three-dots.svg' alt=''>
                        </div></td>";
                  echo "</tr>";
              }
              mysqli_free_result($result);
              ?>
          </tbody>
        </table>
        
        <nav aria-label="Page navigation example">
          <ul class="pagination">
            <li class="page-item">
              <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">«</span>
              </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
              <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">»</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </main>
  </div>
  <script src="js/script.js"></script>
</body>
</html>