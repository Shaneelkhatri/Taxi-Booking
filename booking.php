<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("../../files/settings.php");
// Connect to the database
$connection = mysqli_connect($sql_host, $sql_user, $sql_pass, $sql_db);

// Check the connection
if ($connection->connect_error) {
    echo "<p>Database connection failure: " . $connection->connect_error . "</p>";
    exit();
}



$bookingreference = $_POST["bookingreference"];
$cname = $_POST["cname"];
$phone = $_POST["phone"];
$unumber = $_POST["unumber"];
$snumber = $_POST["snumber"];
$stname = $_POST["stname"];
$sbname = $_POST["sbname"];
$dsbname = $_POST["dsbname"];
$pick_up_date = $_POST["pick_up_date"];
$pick_up_time = $_POST["pick_up_time"];

$status = "unassigned";

$bookingform = "bookingform";

$checktable = mysqli_query($connection, "SHOW TABLES LIKE '$bookingform'");
$is_table_exists = mysqli_num_rows($checktable) > 0;
    if (!$is_table_exists) {
        //if table does not exist create table 
        $create_table = "Create Table $bookingform(
            bookingreference VARCHAR(35) NOT NULL PRIMARY KEY,
            cname VARCHAR(50) NOT NULL,
            phone VARCHAR(12) NOT NULL,
            unumber VARCHAR(255),
            snumber VARCHAR(255) NOT NULL,
            stname VARCHAR(255) NOT NULL,
            sbname VARCHAR(255), 
            dsbname VARCHAR(255),
            pick_up_date DATE NOT NULL DEFAULT CURRENT_DATE,
            pick_up_time TIME NOT NULL DEFAULT CURRENT_TIME,
            status VARCHAR(50) DEFAULT 'unassigned')";
       mysqli_query($connection, $create_table)
       or die();
    }

    $query = "INSERT INTO $bookingform VALUES(
        '$bookingreference',
        '$cname',
        '$phone',
        '$unumber',
        '$snumber',
        '$stname',
        '$sbname',
        '$dsbname',
        '$pick_up_date',
        '$pick_up_time',
        '$status'
        )";

    

if (mysqli_query($connection, $query))
 {
    echo "<h2> Thank you for your booking </h2>";
    echo "<tr><p>Booking reference number: " . $bookingreference. "</p></td></tr>";
    echo "<tr><td><p>Pickup time: " . $pick_up_time. "</p></td></tr>";
    echo "<tr><td><p>Pickup date: " . $pick_up_date. "</p></td></tr>";
} else {
    echo "alert('Booking Failed: " . mysqli_error($connection) . "');";
}

//Close connection
$connection->close();
?>