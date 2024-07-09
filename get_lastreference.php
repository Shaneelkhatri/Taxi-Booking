<?php
$sql_host="localhost";
$sql_user="rzn5038";
$sql_pass="ynhndfsfqqbujhiitamprzuscdxvklw";
$sql_db="rzn5038";


$connection = mysqli_connect($sql_host, $sql_user, $sql_pass, $sql_db);

// Check the connection
if (mysqli_connect_error()) {
    echo json_encode(['error' => "Database connection failure: " . mysqli_connect_error()]);
    exit();
}

header('Content-Type: application/json');

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


$query = "SELECT * FROM bookingform Order By bookingreference DESC";
$result = mysqli_query($connection, $query);
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $response['bookingform'] = fetchBookings($result);
    } else {
        $response['error'] = "zero";
    }
} else {
    $response['error'] = "failed";
}



echo json_encode($response);
mysqli_close($connection);
exit;
?>