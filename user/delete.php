<?php
// Include the database connection file
include '../db_connection.php';

// Get the raw POST data and decode it from JSON format
$data = json_decode(file_get_contents("php://input"), true);

// Extract the user number from the decoded data
$usr_no = $data['usr_no'];

// Create an SQL query to delete the user from the database
$sql = "DELETE FROM user WHERE usr_no='$usr_no'";

// Execute the SQL query and return a JSON response
if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "User deleted successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}

// Close the database connection
$conn->close();
?>
