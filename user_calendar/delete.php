<?php
// Include the database connection file
include '../db_connection.php';

// Get the raw POST data and decode it from JSON format
$data = json_decode(file_get_contents("php://input"), true);

// Extract the uc_no from the decoded data
$uc_no = $data['uc_no'];

// Create an SQL query to delete the record from the user_calendar table based on uc_no
$sql = "DELETE FROM user_calendar WHERE uc_no = '$uc_no'";

// Execute the query and check if it was successful
if ($conn->query($sql) === TRUE) {
    $response = array("status" => "success", "message" => "Event deleted successfully"); // Success response
} else {
    $response = array("status" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error); // Error response with the SQL query and error message
}

// Close the database connection
$conn->close();

// Return the response in JSON format
echo json_encode($response);
?>
