<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("../../files/settings.php");


// Connect to the database
$connection = mysqli_connect($sql_host, $sql_user, $sql_pass, $sql_db);

// Check the connection
if (mysqli_connect_error()) {
    echo json_encode(['error' => "Database connection failure: " . mysqli_connect_error()]);
    exit();
}

// Prepare to send JSON responses
header('Content-Type: application/json');
$response = [];

// Function to fetch and format bookings
function fetchBookings($result) {
    $bookingform = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $bookingform[] = [
            'bookingreference' => $row['bookingreference'],
            'cname' => $row['cname'],
            'phone' => $row['phone'],
            'sbname' => $row['sbname'],
            'dsbname' => $row['dsbname'],
            'pick_up_date' => $row['pick_up_date'],
            'pick_up_time' => $row['pick_up_time'],
            'status' => $row['status']
        ];
    }
    return $bookingform;
}

// Handling search requests
if (isset($_GET['bsearch']) && !empty($_GET['bsearch'])) {
    $bsearch = mysqli_real_escape_string($connection, trim($_GET['bsearch']));
    $query = "SELECT * FROM bookingform WHERE bookingreference = '$bsearch'";
    $result = mysqli_query($connection, $query);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $response['bookingform'] = fetchBookings($result);
        } else {
            $response['message'] = 'No booking found with reference ' . $bsearch;
        }
    } else {
        $response['error'] = 'Database query failed: ' . mysqli_error($connection);
    }
}else if(empty($_GET['bsearch'])){
    $bsearch = mysqli_real_escape_string($connection, trim($_GET['bsearch']));

    $query = "SELECT * FROM bookingform WHERE status='unassigned' AND pick_up_time BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 2 HOUR)";

    $result = mysqli_query($connection, $query);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $response['bookingform'] = fetchBookings($result);
        } else {
            $response['message'] = 'No booking found with reference ' . $bsearch;
        }
    } else {
        $response['error'] = 'Database query failed: ' . mysqli_error($connection);
    }
} 
else {
    $response['error'] = 'No search term provided.';
}

print_r(json_encode($response));

// Close connection
mysqli_close($connection);
exit;
?>