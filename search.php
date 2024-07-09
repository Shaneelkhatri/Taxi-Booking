<?php

require_once("../../files/settings.php");


// Connect to the database
$connection = mysqli_connect($sql_host, $sql_user, $sql_pass, $sql_db);

if ($connection->connect_error) {
    echo "<p>Database connection failure: " . $connection->connect_error . "</p>";
    exit();
}

$bookingrefernce =$_POST['bsearch'];