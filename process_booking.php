<?php
require_once("../../files/settings.php");

$connection = mysqli_connect($sql_host, $sql_user, $sql_pass, $sql_db);

$cname = $_POST['cname'];
$phone = $_POST['phone'];
$unumber = $_POST['unumber'] ?? '';
$snumber = $_POST['snumber'];
$stname = $_POST['stname'];
$sbname = $_POST['sbname'] ?? '';
$dsbname = $_POST['dsbname'] ?? '';
$date = $_POST['date'];
$time = $_POST['time'];

// Generate booking reference number
$query = "SELECT MAX(SUBSTRING(booking_ref, 4)) AS max_ref FROM bookings";
$result = mysqli_query($connection , $query);
$row = mysqli_fetch_assoc($result);
$max_ref = $row['max_ref'] ? intval($row['max_ref']) + 1 : 1;
$booking_ref = 'BRN' . str_pad($max_ref, 5, '0', STR_PAD_LEFT);

// Insert booking into database
$query = "INSERT INTO bookingform (booking_ref, cname, phone, unumber, snumber, stname, sbname, dsbname, pick_date, pick_time) 
          VALUES ('$booking_ref', '$cname', '$phone', '$unumber', '$snumber', '$stname', '$sbname', '$dsbname', '$date', '$time')";
if (mysqli_query($connection , $query)) {
    $confirmation_msg = "Thank you for your booking!<br>";
    $confirmation_msg .= "Booking reference number: $booking_ref<br>";
    $confirmation_msg .= "Pickup time: $time<br>";
    $confirmation_msg .= "Pickup date: $date";
    echo $confirmation_msg;
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($connection );
}

mysqli_close($connection );
?>
