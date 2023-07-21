<?php
    include "config.php";
    session_start();

    if(!isset($_SESSION['patient_id'])) {
        die("No patient ID found in session.");
    }

    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if(mysqli_connect_errno()) {
        die("DB connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
    }

    $patient_id = $_SESSION['patient_id'];

    $query = "SELECT * FROM tbl_228_patients WHERE patient_id='{$patient_id}'";
    $result = mysqli_query($connection, $query);

    if(mysqli_num_rows($result) == 1){
        $patient = mysqli_fetch_assoc($result);
    } else {
        die("No patient found with ID {$patient_id}.");
    }

    $submitSuccess = false; 

    
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['smart_type'])) {
      $smart_type = mysqli_real_escape_string($connection, $_GET['smart_type']);
      $smart_time = date('Y-m-d H:i:s');
      $smart_risk = $patient['patient_risk'];
      $smart_risk_desc = $patient['patient_risk_desc'];
      $smart_initials = $patient['patient_initials'];
      $smart_room = $patient['patient_room'];

      $query = "INSERT INTO tbl_228_smartcalls (smart_type, smart_time, smart_risk, smart_risk_desc, patient_id, smart_initials, smart_room) VALUES ('$smart_type', '$smart_time', '$smart_risk', '$smart_risk_desc', '$patient_id', '$smart_initials', $smart_room)";
      $result = mysqli_query($connection, $query);

      if($result){
          $submitSuccess = true; 
      } else {
          die("DB query failed.");
      }
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
    <title>Welcome <?php echo $patient['patient_firstname']; ?></title>
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
        <a href = patientInterface.php>
            <li class="galit-li">
              <img class="galit" src="img/blank-prof.png" /><?php echo $patient['patient_firstname'] . ' ' . $patient['patient_lastname']; ?>
            </li>
        </a>
            <hr>
            <a href="logout.php">
              <li><img class="side-icons" src="svg/box-arrow-in-right.svg">Logout<img class="arrow"
                  src="svg/caret-right-fill.svg" /></li>
            </a>
          </ul>
        </div>
      </nav>
      <main class="main-content">
        <h1>Welcome <?php echo $patient['patient_firstname']; ?></h1>       
        <hr class = "head-hr"/>
        <div class="container mt-5 mb-5">  
    <div class="row g-2">
        <div class="col-md-3">
            <div class="card p-2 py-3 text-center">
                <div class="img mb-2">
                    <img src="img/nurse.png" width="70" class="rounded-circle">                    
                </div>
                <h5 class="mb-0">Nurse</h5>
                <div class="ratings mt-2">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>                   
                </div>
                <div class="mt-4 apointment">
                    <form method="GET" action="patientInterface.php" onsubmit="return showSuccessMessage()">
                        <input type="hidden" name="smart_type" value="Nurse">
                        <button type="submit" class="btn btn-success text-uppercase">Select</button>
                    </form>                             
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-2 py-3 text-center">
                <div class="img mb-2">
                    <img src="img/staffAssist.PNG" width="70" class="rounded-circle">
                </div>
                <h5 class="mb-0">Staff Assist</h5>
                <div class="ratings mt-2">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                </div>
                <div class="mt-4 apointment">
                <form method="GET" action="patientInterface.php" onsubmit="return showSuccessMessage()">
                      <input type="hidden" name="smart_type" value="Staff Assist">
                      <button type="submit" class="btn btn-success text-uppercase">Select</button>
                  </form>                             
                </div>
            </div>            
        </div>
        <div class="col-md-3">
            <div class="card p-2 py-3 text-center">
                <div class="img mb-2">
                    <img src="img/meal.png" width="70" class="rounded-circle">   
                </div>
                <h5 class="mb-0">Nutrition</h5>
                <div class="ratings mt-2">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>                  
                </div>
                <div class="mt-4 apointment">
                <form method="GET" action="patientInterface.php" onsubmit="return showSuccessMessage()">
                      <input type="hidden" name="smart_type" value="Nutrition">
                      <button type="submit" class="btn btn-success text-uppercase">Select</button>
                  </form>                             
                </div>
            </div>           
        </div>
        <div class="col-md-3">
    <div class="card p-2 py-3 text-center">
        <div class="img mb-2">
            <img src="img/voiceCall.png" width="70" class="rounded-circle">
        </div>
        <h5 class="mb-0">Voice Call</h5>
        <div class="ratings mt-2">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
        </div>
        <div class="mt-4 apointment">
        <form method="GET" action="patientInterface.php" onsubmit="return showSuccessMessage()">
                      <input type="hidden" name="smart_type" value="Voice Call">
                      <button type="submit" class="btn btn-success text-uppercase">Select</button>
                  </form>
            <div class="notification-area" style="display: none;">
                <p>The request has been successfully sent, and the medical team is on its way to you.</p>
                <button class="btn btn-danger text-uppercase" onclick="cancelRequest()">Cancel the request</button>
            </div>
        </div>
    </div>
</div>
        <div class="col-md-3">
            <div class="card p-2 py-3 text-center">
                <div class="img mb-2">
                    <img src="img/cleanliness.png" width="70" class="rounded-circle">                   
                </div>
                <h5 class="mb-0">Cleaning</h5>
                <div class="ratings mt-2">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>       
                </div>
                <div class="mt-4 apointment">
                <form method="GET" action="patientInterface.php" onsubmit="return showSuccessMessage()">
                      <input type="hidden" name="smart_type" value="Cleaning">
                      <button type="submit" class="btn btn-success text-uppercase">Select</button>
                  </form>                             
                </div>
            </div>           
        </div>
        <div class="col-md-3">
            <div class="card p-2 py-3 text-center">
                <div class="img mb-2">
                    <img src="img/Medication.png" width="70" class="rounded-circle">
                </div>
                <h5 class="mb-0">Medications</h5>
                <div class="ratings mt-2">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i> 
                </div>
                <div class="mt-4 apointment">
                <form method="GET" action="patientInterface.php" onsubmit="return showSuccessMessage()">
                      <input type="hidden" name="smart_type" value="Medications">
                      <button type="submit" class="btn btn-success text-uppercase">Select</button>
                  </form>                             
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-2 py-3 text-center">
                <div class="img mb-2">
                    <img src="img/lavatory.png" width="70" class="rounded-circle">                    
                </div>
                <h5 class="mb-0">Lavatory</h5>
                <div class="ratings mt-2">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>                   
                </div>
                <div class="mt-4 apointment">
                <form method="GET" action="patientInterface.php" onsubmit="return showSuccessMessage()">
                      <input type="hidden" name="smart_type" value="Lavatory">
                      <button type="submit" class="btn btn-success text-uppercase">Select</button>
                  </form>                             
                </div>
            </div>            
        </div>
        <div class="col-md-3">
            <div class="card p-2 py-3 text-center">
                <div class="img mb-2">
                    <img src="img/others.png" width="70" class="rounded-circle">                    
                </div>
                <h5 class="mb-0">Other</h5>               
                <div class="ratings mt-2">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>                   
                </div>
                <div class="mt-4 apointment">
                <form method="GET" action="patientInterface.php" onsubmit="return showSuccessMessage()">
                      <input type="hidden" name="smart_type" value="Other">
                      <button type="submit" class="btn btn-success text-uppercase">Select</button>
                  </form>                             
                </div>
            </div>            
        </div>        
    </div>
   </div>
   <div class="fixed left-0 top-0 flex h-full w-full items-center justify-center bg-black bg-opacity-50 py-10 notification-area" style="display: none;">
    <div class="max-h-full w-full max-w-xl overflow-y-auto sm:rounded-2xl bg-white">
        <div class="w-full">
            <div class="m-8 my-20 max-w-[400px] mx-auto">
                <div class="mb-8">
                    <h1 class="mb-4 text-3xl font-extrabold">Turn on notifications</h1>
                    <p class="text-gray-600">Get the most out of Twitter by staying up to date with what's happening.
                    </p>
                </div>
                <div class="space-y-4">
                    <button class="p-3 bg-black rounded-full text-white w-full font-semibold">Allow notifications</button>
                    <button class="p-3 bg-white border rounded-full w-full font-semibold">Skip for now</button>
                    <!-- Add a "Cancel the request" button -->
                    <button class="p-3 bg-red-500 rounded-full text-white w-full font-semibold" onclick="cancelRequest()">Cancel the request</button>
                </div>
            </div>
        </div>
    </div>
</div>
      </main>
    </div> 
    <div id="modalBox" class="container">
    <div class="container">
        <input type="checkbox" id="check">
        <div class="background"></div>
        <div class="alert_box">
            <div class="icon">
                <img src="img/check.PNG" width="90" >
            </div>
            <h2>Success</h2>
            <p>Your call has been received! The medical team will arrive shortly.</p>
            <div class="btns">
                <a href="#">
                    <img src="img/fingerprint.png" width="70" class="rounded-circle" alt="Click image" onclick="hideSuccessMessage()">
                </a>
                <label class="show_button" onclick="hideSuccessMessage()">Cancel</label>
            </div>
        </div>
    </div>
</div>
    <script src="js/success.js"></script>
    <script src = "js/script.js"></script> 
  </body>
</html>
