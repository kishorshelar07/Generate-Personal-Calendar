<?php
include '../db_connection.php';

// Get the raw POST data
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['uc_no']) && is_numeric($data['uc_no'])) {
    $uc_no = $data['uc_no'];
    $usr_id = $data['usr_id'];
    $uc_msg = $data['uc_msg'];
    $uc_date_event_csv = $data['uc_date_event_csv'];
    $uc_event_details_csv = $data['uc_event_details_csv'];
    $uc_num_page = $data['uc_num_page'];
    $uc_start_date = $data['uc_start_date'];
    $uc_end_date = $data['uc_end_date'];
    $uc_calendar_type = $data['uc_calendar_type'];
    $uc_page_header = $data['uc_page_header'];
    $uc_page_footer = $data['uc_page_footer'];
    $uc_remarks = $data['uc_remarks'];

    // Prepare the SQL query to update the event
    $stmt = $conn->prepare("UPDATE user_calendar SET usr_id=?, uc_msg=?, uc_date_event_csv=?, uc_event_details_csv=?, uc_num_page=?, uc_start_date=?, uc_end_date=?, uc_calendar_type=?, uc_page_header=?, uc_page_footer=?, uc_remarks=? WHERE uc_no=?");

    // Bind parameters (ensure the correct data types: 's' for string, 'i' for integer)
    $stmt->bind_param("ssssissssssi", $usr_id, $uc_msg, $uc_date_event_csv, $uc_event_details_csv, $uc_num_page, $uc_start_date, $uc_end_date, $uc_calendar_type, $uc_page_header, $uc_page_footer, $uc_remarks, $uc_no);

    // Execute the query
    if ($stmt->execute()) {
        echo json_encode(["status" => "success" , "message" => "User updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update event. Error: " . $stmt->error]);
    }

    // Close the statement
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Missing or invalid uc_no"]);
}

// Close the database connection
$conn->close();
?>
