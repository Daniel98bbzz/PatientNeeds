<?php
    include "config.php";

if (isset($_GET['smart_id'])) {
    $smart_id = $_GET['smart_id'];

    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    $query = "INSERT INTO tbl_228_smartcalls_history SELECT * FROM tbl_228_smartcalls WHERE smart_id = $smart_id";
    $result = mysqli_query($connection, $query);;
    if (!$result) {
        die("Query failed: " . $connection->error);
    }

    $query = "DELETE FROM tbl_228_smartcalls WHERE smart_id = $smart_id";
    $result = mysqli_query($connection, $query);;
    if (!$result) {
        die("Query failed: " . $connection->error);
    }

    echo "Success";
} else {
    echo "No smart_id provided";
}
?>