<?php 
// Include the database connection file
include "../db_connection.php";

// Read the input data
$data = json_decode(file_get_contents('php://input'), true);

if(isset($data['usr_id']) && isset($data['usr_pass'])) {
    // Retrieve form data
    $username = $data['usr_id'];
    $password = $data['usr_pass'];

    // Update SQL query to also select usr_status
    $sql = "SELECT usr_id, usr_name, usr_type, usr_status FROM user WHERE usr_id = '$username' AND usr_pass = '$password'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {   
        $row = mysqli_fetch_assoc($result);

        if ($row['usr_status'] == 1) {
            // If user is status
            $response = array(
                'status' => 'success',
                'usr_id' => $row["usr_id"],
                'usr_name' => $row["usr_name"],
                'usr_type' => $row["usr_type"]
            );
        } else {
            // If user is instatus
            $response = array(
                'status' => 'error',
                'message' => 'User not Active. Please contact admin.'
            );
        }
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Invalid userid or password!'
        );
    }

    // Send response in JSON format
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
