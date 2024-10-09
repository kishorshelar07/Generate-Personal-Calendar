<?php
// Include the database connection file
include '../db_connection.php';

// Get the raw POST data and decode it from JSON format
$data = json_decode(file_get_contents("php://input"), true);

// Extract individual fields from the decoded data
$usr_no = $data['usr_no'];
$usr_id = $data['usr_id'];
$usr_name = $data['usr_name'];
$usr_pass = $data['usr_pass'];
$usr_status = $data['usr_status'];
$usr_type = $data['usr_type'];
$usr_dob = $data['usr_dob'];
$usr_email = $data['usr_email'];

// Create an SQL query to update the existing user in the database
$sql = "UPDATE user SET usr_id='$usr_id', usr_name='$usr_name', usr_pass='$usr_pass', usr_status='$usr_status', usr_type='$usr_type', usr_dob='$usr_dob', usr_email='$usr_email' WHERE usr_no='$usr_no'";

// Execute the SQL query and return a JSON response
if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "User updated successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}

// Close the database connection
$conn->close();
?>
