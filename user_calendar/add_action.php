<?php
// Include the database connection file
include '../db_connection.php';

// Get the raw POST data and decode it from JSON format
$data = json_decode(file_get_contents("php://input"), true);

// Extract individual fields from the decoded data
$usr_id = $data['usr_id'];
$uc_msg = $data['uc_msg'];
$uc_date_event_csv = $data['uc_date_event_csv'];
$uc_event_details_csv = $data['uc_event_details_csv'];
$uc_num_page = $data['uc_num_page'];
$uc_start_date = $data['uc_start_date'];
$uc_end_date = $data['uc_end_date'];
$uc_calendar_type = $data['uc_calendar_type'];
$uc_remarks = $data['uc_remarks'];
$uc_page_header = $data['uc_page_header'];
$uc_page_footer = $data['uc_page_footer'];


// Create an SQL query to insert a new record into the user_calendar table
$sql = "INSERT INTO user_calendar (usr_id, uc_msg, uc_date_event_csv, uc_event_details_csv, uc_num_page, uc_start_date, uc_end_date, uc_calendar_type,uc_page_header,uc_page_footer ,uc_remarks) 
        VALUES ('$usr_id', '$uc_msg', '$uc_date_event_csv', '$uc_event_details_csv', '$uc_num_page', '$uc_start_date', '$uc_end_date', '$uc_calendar_type','$uc_page_header', '$uc_page_footer','$uc_remarks')";

// Execute the query and check if it was successful
if ($conn->query($sql) === TRUE) {
    $response = array("status" => "success" , "message" => "User added successfully"); // Success response
} else {
    $response = array("status" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error); // Error response with the SQL query and error message
}

// Close the database connection
$conn->close();

// Return the response in JSON format
echo json_encode($response);
?>
