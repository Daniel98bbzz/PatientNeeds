<?php
    include "config.php";

if (isset($_GET['patient_id'])) {
    $patient_id = $_GET['patient_id'];

    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    $query = "INSERT INTO tbl_228_patients_history SELECT * FROM tbl_228_patients WHERE patient_id = $patient_id";
    $result = mysqli_query($connection, $query);;
    if (!$result) {
        die("Query failed: " . $connection->error);
    }

    $query = "DELETE FROM tbl_228_patients WHERE patient_id = $patient_id";
    $result = mysqli_query($connection, $query);;
    if (!$result) {
        die("Query failed: " . $connection->error);
    }

    echo "Success";
} else {
    echo "No patient_id provided";
}
?>