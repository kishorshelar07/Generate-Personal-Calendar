<?php
include '../db_connection.php';

$uc_no = isset($_GET['uc_no']) ? $_GET['uc_no'] : null; // Check if uc_no is passed via GET request and assign it to $uc_no
$event_rec = null; // Initialize the $event_rec variable to null

if ($uc_no) {
    $sql = "SELECT * FROM user_calendar WHERE uc_no = $uc_no"; // SQL query to fetch event details based on uc_no
    $result = $conn->query($sql); // Execute the query
    $event_rec = $result->fetch_assoc(); // Fetch the event details as an associative array
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $uc_no ? 'Edit ' : 'Add '; ?></title> <!-- Set the title based on the presence of uc_no -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery UI CSS -->
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="text-center"><?php echo $uc_no ? 'Edit ' : 'Add '; ?></h1> <!-- Display the heading based on the presence of uc_no -->
        <form id="eventForm">
            <input type="hidden" name="uc_no" value="<?php echo $uc_no ? $uc_no : ''; ?>"> <!-- Hidden input field for uc_no -->
            <div class="mb-3">
                <label for="usr_id" class="form-label">Mobile Number</label>
                <input type="text" class="form-control" id="usr_id" name="usr_id" value="<?php echo $event_rec ? $event_rec['usr_id'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="uc_msg" class="form-label">Message</label>
                <input type="text" class="form-control" id="uc_msg" name="uc_msg" value="<?php echo $event_rec ? $event_rec['uc_msg'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="uc_date_event_csv" class="form-label">Date Event CSV</label>
                <input type="text" class="form-control" id="uc_date_event_csv" name="uc_date_event_csv" value="<?php echo $event_rec ? $event_rec['uc_date_event_csv'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="uc_event_details_csv" class="form-label">Event Details CSV</label>
                <input type="text" class="form-control" id="uc_event_details_csv" name="uc_event_details_csv" value="<?php echo $event_rec ? $event_rec['uc_event_details_csv'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="uc_num_page" class="form-label">Number of Pages</label>
                <input type="number" class="form-control" id="uc_num_page" name="uc_num_page" value="<?php echo $event_rec ? $event_rec['uc_num_page'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="uc_start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="uc_start_date" name="uc_start_date" value="<?php echo $event_rec ? $event_rec['uc_start_date'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="uc_end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="uc_end_date" name="uc_end_date" value="<?php echo $event_rec ? $event_rec['uc_end_date'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="uc_calendar_type" class="form-label">Calendar Type</label>
                <select class="form-control" id="uc_calendar_type" name="uc_calendar_type" required>
                    <option  <?php echo $event_rec && $event_rec['uc_calendar_type'] == '' ? 'selected' : ''; ?>>Select</option>
                    <option value="template_1" <?php echo $event_rec && $event_rec['uc_calendar_type'] == 'Template 1' ? 'selected' : ''; ?>>1 Page</option>
                    <option value="template_2" <?php echo $event_rec && $event_rec['uc_calendar_type'] == 'Template 2' ? 'selected' : ''; ?>>12 Page</option>
                    <option value="template_3" <?php echo $event_rec && $event_rec['uc_calendar_type'] == 'Template 3' ? 'selected' : ''; ?>>3 Page</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="uc_page_header" class="form-label">Page Header</label>
                <input type="text" class="form-control" id="uc_page_header" name="uc_page_header" value="<?php echo $event_rec ? $event_rec['uc_page_header'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="uc_page_footer" class="form-label">Page Footer</label>
                <input type="text" class="form-control" id="uc_page_footer" name="uc_page_footer" value="<?php echo $event_rec ? $event_rec['uc_page_footer'] : ''; ?>" >
            </div>
            <div class="mb-3">
                <label for="uc_remarks" class="form-label">Remarks</label>
                <input type="text" class="form-control" id="uc_remarks" name="uc_remarks" value="<?php echo $event_rec ? $event_rec['uc_remarks'] : ''; ?>" >
            </div>
            <button type="submit" class="btn btn-primary"><?php echo $uc_no ? 'Update' : 'Add'; ?> </button> <!-- Button to submit the form -->
        </form>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery UI JS -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    $(document).ready(function() {
        var selectedDates = [];
        $("#uc_date_event_csv").datepicker({
            dateFormat: 'yy/mm/dd',
            onSelect: function(dateText) {
                if (!selectedDates.includes(dateText)) {
                    selectedDates.push(dateText);
                    $("#uc_date_event_csv").val(selectedDates.join(', '));
                }
            },
            beforeShowDay: function(date) {
                var dateString = $.datepicker.formatDate('yy/mm/dd', date);
                return [selectedDates.indexOf(dateString) == -1];
            }
        });

        $('#eventForm').on('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            var formData = $(this).serializeArray(); // Serialize form data
            var data = {}; // Initialize an empty object for data

            formData.forEach(function(item) {
                data[item.name] = item.value; // Populate the data object
            });

            $.ajax({
                url: '<?php echo $uc_no ? 'update_action.php' : 'add_action.php'; ?>', // Set the URL based on add or edit
                type: 'POST', // Set the request method to POST
                data: JSON.stringify(data), // Convert data to JSON string
                contentType: 'application/json', // Set content type to JSON
                success: function(resp_data) { // On successful response
                    var res = JSON.parse(resp_data); // Parse the JSON response
                    if (res.status === 'success') { // If status is success
                        window.parent.updateEventTable(); // Call updateEventTable function on parent window
                        window.parent.$('#eventModal').modal('hide'); // Hide the modal on parent window
                    } else { // If there is an error
                        alert('Error: ' + res.message); // Display the error message
                    }
                },
            });
        });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
