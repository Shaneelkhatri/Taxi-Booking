<?php
require_once("../../files/settings.php");

// Connect to the database
$connection = mysqli_connect($sql_host, $sql_user, $sql_pass, $sql_db);

if (isset($_GET['bsearch'])) {
    $searchValue = $_GET['bsearch'];
    if (preg_match('/^BRN\d{5}$/', $searchValue)) {
        $query = "SELECT * FROM bookingform WHERE bookingreference = '$searchValue'";
    } else {
        $query = "SELECT * FROM bookingform WHERE pick_date = CURDATE() AND pick_time BETWEEN CURTIME() AND ADDTIME(CURTIME(), '02:00')";
    }
} else if (isset($_GET['assign'])) {
    $bookingRef = $_GET['assign'];
    $query = "UPDATE bookingform SET assignment_status = 'assigned' WHERE booking_ref = '$bookingRef'";
    if (mysqli_query($connection , $query)) {
        echo "Booking $bookingreference has been assigned!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection );
    }
    exit();
} else {
    $query = "SELECT * FROM bookingform WHERE pick_date = CURDATE() AND pick_time BETWEEN CURTIME() AND ADDTIME(CURTIME(), '02:00')";
}

$result = mysqli_query($connection , $query);
if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'>
            <tr>
                <th>Booking reference number</th>
                <th>Customer name</th>
                <th>Phone</th>
                <th>Pickup suburb</th>
                <th>Destination suburb</th>
                <th>Pickup date and time</th>
                <th>Status</th>
                <th>Assign</th>
            </tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['bookingreference']}</td>
                <td>{$row['cname']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['sbname']}</td>
                <td>{$row['dsbname']}</td>
                <td>{$row['pick_date']} {$row['pick_time']}</td>
                <td>{$row['assignment_status']}</td>
                <td><button data-booking-ref='{$row['booking_ref']}'>Assign</button></td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "No bookings found.";
}

mysqli_close($connection );
?>
