<?php
include "config.php";

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if(mysqli_connect_errno()) {
    die("DB connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
}

$queryV = "SELECT HOUR(smart_time) AS hour, COUNT(*) AS count FROM tbl_228_smartcalls WHERE smart_type = 'Voice Call' GROUP BY HOUR(smart_time)";
$resultV = mysqli_query($connection, $queryV);

$dataV = array();
foreach ($resultV as $rowV) {
  $dataV[] = $rowV;
}

print json_encode($dataV);
?>