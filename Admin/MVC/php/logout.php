<?php
session_start();
include '../db/config.php';


if (isset($_SESSION['admin_id'])) {
    $activity_query = "INSERT INTO activities (user_id, action, description) VALUES ('{$_SESSION['admin_id']}', 'logout', 'Admin logged out')";
    mysqli_query($conn, $activity_query);
}


session_destroy();


header("Location: ../html/login.php");
exit;
?>


