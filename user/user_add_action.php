<?php
// Include the database connection file
include '../db_connection.php';

// Get the raw POST data and decode it from JSON format
$data = json_decode(file_get_contents("php://input"), true);

// Extract individual fields from the decoded data
$usr_id = $data['usr_id'];
$usr_name = $data['usr_name'];
$usr_pass = $data['usr_pass'];
$usr_status = $data['usr_status'];
$usr_type = $data['usr_type'];
$usr_dob = $data['usr_dob'];
$usr_email = $data['usr_email'];

// Create an SQL query to insert the new user into the database
$sql = "INSERT INTO user ( usr_id, usr_name, usr_pass, usr_status, usr_type, usr_dob, usr_email) 
        VALUES ( '$usr_id', '$usr_name', '$usr_pass', '$usr_status', '$usr_type', '$usr_dob', '$usr_email')";

// Execute the SQL query and return a JSON response
if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "User added successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}

// Close the database connection
$conn->close();
?>
