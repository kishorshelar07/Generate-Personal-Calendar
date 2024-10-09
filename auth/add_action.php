<?php
// Include the database connection file
include "../db_connection.php";

// Read the input data
$data = json_decode(file_get_contents('php://input'), true);

if(isset($data['usr_name']) && isset($data['usr_id']) && isset($data['usr_email']) && isset($data['usr_dob']) && isset($data['usr_pass']) && isset($data['usr_gender'])) {
    // Retrieve form data
    $usr_name = $data['usr_name'];
    $usr_id = $data['usr_id'];
    $usr_email = $data['usr_email'];
    $usr_dob = $data['usr_dob'];
    $usr_pass = $data['usr_pass'];
    $usr_gender = $data['usr_gender'];

    // Insert user data into the database
    $sql = "INSERT INTO `user` (`usr_name`, `usr_id`, `usr_email`, `usr_dob`, `usr_pass`, `usr_gender`) VALUES ('$usr_name', '$usr_id', '$usr_email', '$usr_dob', '$usr_pass', '$usr_gender')";

    if (mysqli_query($conn, $sql)) { 
        $response = array('status' => 'success', 'message' => 'User registered successfully!');
    } else {
        $response = array('status' => 'error', 'message' => 'Error: ' . mysqli_error($conn));
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
