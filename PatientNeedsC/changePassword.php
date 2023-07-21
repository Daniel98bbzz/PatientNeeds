<?php
session_start();
if(!isset($_SESSION['user_email'])){
    header('Location: login.php');
    exit;
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "config.php";

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if(mysqli_connect_errno()) {
    die("DB connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userId = $_GET['user-id'];
    $newPassword = $_GET['confirm-password'];

    echo "UserID: $userId <br>";
    echo "Password: $newPassword <br>";

    if(empty($userId) || empty($newPassword)) {
        die("User ID or password cannot be empty.");
    }

    $updateQuery = "UPDATE tbl_228_users SET user_password = ? WHERE user_r_id = ?";
    
    if($stmt = $connection->prepare($updateQuery)){
        $stmt->bind_param("si", $newPassword, $userId);

        if(!$stmt->execute()) {
            die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        } else {
            echo "Password updated successfully.";
        }
    } else {
        die("Error preparing statement: " . $connection->error);
    }
}

mysqli_close($connection);
?>
