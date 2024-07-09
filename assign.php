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
if (isset($_POST['bsearch']) && !empty($_POST['bsearch'])) {
    $bsearch = mysqli_real_escape_string($connection, trim($_POST['bsearch']));


    $sql = "UPDATE bookingform SET status = 'assigned' WHERE bookingreference = '$bsearch'";



    // Execute the statement
    if ( mysqli_query($connection, $sql)) {
        $response['success']='success';
    } else {
        $response['error'] = 'Database query failed: ' . mysqli_error($connection);
    }

} else {
    $response['error'] = 'No search term provided.';
}

echo json_encode($response);
mysqli_close($connection);
exit;
?>