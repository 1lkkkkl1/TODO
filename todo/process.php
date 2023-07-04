<?php
set_time_limit(120);
include_once("db_connect.php");
include_once("config.php");
session_start();

if (isset($_POST['closeAccess'])) {
    if (!isset($_COOKIE["session"])) {
        echo "error";
        exit;
    }

    $sessionId = $_COOKIE["session"];
    $query = "UPDATE users_todo SET access = 0 WHERE id = '$sessionId'";
    $result = mysqli_query($connection, $query);
    if ($result) {
        echo "success";
    } else {
        echo "error";
    }
    exit;
}

if (isset($_POST['openAccess'])) {
    if (!isset($_COOKIE["session"])) {
        echo "error";
        exit;
    }

    $sessionId = $_COOKIE["session"];
    $query = "UPDATE users_todo SET access = 1 WHERE session = '$userId'";
    $result = mysqli_query($connection, $query);
    if ($result) {
        echo "success";
    } else {
        echo "error";
    }
    exit;
}
?>
