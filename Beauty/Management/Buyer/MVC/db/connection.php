<?php
include_once 'config.php';

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, PORT);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($connection, "utf8");

function executeQuery($query)
{
    global $connection;
    $result = mysqli_query($connection, $query);
    return $result;
}

function fetchAll($query)
{
    global $connection;
    $result = mysqli_query($connection, $query);
    $data = array();

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
    return $data;
}
function fetchOne($query)
{
    global $connection;
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    return null;
}

function escapeInput($input)
{
    global $connection;
    return mysqli_real_escape_string($connection, $input);
}

function getLastInsertedId()
{
    global $connection;
    return mysqli_insert_id($connection);
}
