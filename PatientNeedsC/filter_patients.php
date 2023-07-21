<?php
include "config.php";
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$riskLevel = mysqli_real_escape_string($connection, $_GET['risk_level']);

$query = "SELECT * FROM tbl_228_patients WHERE patient_risk = ?";

$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "s", $riskLevel);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td><div class='status " . strtolower($row["patient_risk"]) . "'></div></td>";
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

mysqli_stmt_close($stmt);
mysqli_close($connection);
?>