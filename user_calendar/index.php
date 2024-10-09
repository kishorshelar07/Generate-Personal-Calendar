<?php
// Include database connection script to connect to the database
include '../db_connection.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Calendar List</title>
    <link rel="icon" type="image/png" href="../img/favicon.png">

    <!-- Bootstrap CSS  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding-top: 20px;
        }

        .container-fluid {
            max-width: 100%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-size: 12px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: black;
            font-weight: bold;
            border-bottom: 1px solid  black;
        }

        .table {
            width: 100%;
            margin-top: 20px;
        }

        .table th,
        .table td {
            padding: 10px;
            text-align: left;
        }

        .table th {
            background-color: lightgray;
            color: black;
        }

        .table tbody tr:hover {
            background-color: #f0f0f0;
        }

        .btn {
            padding: 5px 10px;
        }

        .modal-content {
            border-radius: 8px;
        }

        .image-column {
            max-width: 300px;
            white-space: nowrap;
        }

        .image-preview {
            display: inline-block;
            margin-right: 5px;
        }

        .image-preview img {
            height: 60px;
            margin-bottom: 10px;
        }

        .gen-btn {
            width: 8em;
            height: 2em;
            margin: 0.5em;
            background-color: #636161;
            color: white;
            border: none;
            border-radius: 0.625em;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .gen-btn:hover {
            color: black;
        }

        .gen-btn:after {
            content: "";
            background: white;
            position: absolute;
            z-index: -1;
            left: -20%;
            right: -20%;
            top: 0;
            bottom: 0;
            transform: skewX(-45deg) scale(0, 1);
            transition: all 0.5s;
        }

        .gen-btn:hover:after {
            transform: skewX(-45deg) scale(1, 1);
            -webkit-transition: all 0.5s;
            transition: all 0.5s;
        }

        .display-img {
            border-radius: 15px;
            height: 20px;
            font-size: 10px;
        }


        #gen-cal {
            height: 40px;
            width: 80px;
            color: white;
            text-decoration: none;
            font-size: 10px;
            border: none;
            background-color: #636161;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            margin-top: 4px;
        }

        #gen-cal::before {
            margin-left: auto;
        }

        #gen-cal::after,
        #gen-cal::before {
            content: '';
            width: 0%;
            height: 2px;
            background: #f44336;
            display: block;
            transition: 0.5s;
        }

        #gen-cal:hover::after,
        #gen-cal:hover::before {
            width: 100%;
        }

        #searchInput {
            width: 300px;
            margin-left: 740px;

        }

        .search-btn {
            margin-left: 5px;

        }

       
    </style>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>

    <div class="container-fluid">


        <!-- Message Div -->
        <div style="text-align:center;">
            <p id="message" class="alert d-none "></p>
        </div>

        <h1>User Calendar Detail</h1>


        <!-- Search Form -->
        <div class="mb-3 d-flex">
            <div>
                <!-- Button to trigger modal for adding a user calendar event -->
                <button type="button" class="btn btn-primary" id="addEventButton" data-bs-toggle="modal" data-bs-target="#eventModal">Add</button>
            </div>
            <form id="searchForm" class="d-flex">
                <input type="text" id="searchInput" class="form-control" placeholder="Search by Mobile Number...">
                <button type="submit" class="btn btn-dark search-btn "><i class="bi bi-search"></i></button>
            </form>

        </div>

        <table class="table table-striped table-bordered  ">
            <thead>
                <tr>
                    <!-- Table headers for user calendar details -->
                    <th>Sr. No</th>
                    <th>User ID</th>
                    <th>Message</th>
                    <th>Date Event </th>
                    <th>Event Details</th>
                    <th class="image-column">Images</th>
                    <th>No. of Pages</th>
                    <th class="date-range">Date Range</th>
                    <th>Calendar Type</th>
                    <th>Page Header</th>
                    <th>Page Footer</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="eventTableBody">
                <?php


                // Read current user ID and user type from cookie
                $curr_usr_id = $_COOKIE['usr_id'];
                $curr_usr_type = $_COOKIE['usr_type'];
                $searchInput = isset($_POST['searchInput']) ? $_POST['searchInput'] : '';

                // Compose query to restrict row for current user ID
                $where_clause = $curr_usr_type == "Admin" ? "WHERE 1=1" : "WHERE usr_id='$curr_usr_id'";

                // Add search filter for usr_id
                if (!empty($searchInput)) {
                    $searchInput = $conn->real_escape_string($searchInput);
                    $where_clause .= " AND usr_id LIKE '%$searchInput%'";
                }

                // Fetch user data from the database with the WHERE clause
                $sql = "SELECT * FROM user_calendar $where_clause";
                $result = $conn->query($sql);

                // Check if there are any events in the database
                if ($result->num_rows > 0) {
                    // Loop through each event and display their details in the table
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['uc_no'] . "</td>";
                        echo "<td>" . $row['usr_id'] . "</td>";
                        echo "<td>" . $row['uc_msg'] . "</td>";
                        echo "<td>" . $row['uc_date_event_csv'] . "</td>";
                        echo "<td>" . $row['uc_event_details_csv'] . "</td>";

                        echo "<td class='image-column' id='image-column-" . $row['uc_no'] . "'>";
                        $images = explode(', ', $row['uc_img_csv']);
                        if (empty($row['uc_img_csv'])) {
                            echo "No image found";
                        } else {
                            $imageCount = 0;
                            foreach ($images as $index => $image) {
                                if ($index < 4) {
                                    // Correct the image path
                                    $imagePath = '../uploads/' . $image;
                                    echo "<div class='image-preview'><img src='$imagePath' alt='User Image'></div>";
                                }
                                $imageCount++;
                            }
                            if ($imageCount > 4) {
                                $remainingImages = $imageCount - 4;
                                echo "<div class='image-preview'><button type='button' class='uploadImageButton display-img' data-bs-toggle='modal' data-bs-target='#uploadImageModal' data-uc_no='" . $row['uc_no'] . "'> +" . $remainingImages . " More...</button></div>";
                            }
                        }
                        echo "<br><button type='button' class='uploadImageButton gen-btn' data-bs-toggle='modal' data-bs-target='#uploadImageModal' data-uc_no='" . $row['uc_no'] . "'>Upload Image</button>";
                        echo "</td>";


                        echo "<td>" . $row['uc_num_page'] . "</td>";
                        // Combine start and end date in one column
                        echo "<td>" . "Start Date " . $row['uc_start_date'] . "<br><hr>" . "End Date " . $row['uc_end_date'] . "</td>";
                        echo "<td>" . $row['uc_calendar_type'] . "</td>";
                        echo "<td>" . $row['uc_page_header'] . "</td>";
                        echo "<td>" . $row['uc_page_footer'] . "</td>";
                        echo "<td>" . $row['uc_remarks'] . "</td>";
                        echo "<td>
                            <!-- Buttons to edit and delete event -->
                            <button type='button' class='btn btn-primary btn-sm editEventButton' data-bs-toggle='modal' data-bs-target='#eventModal' data-uc_no='" . $row['uc_no'] . "'><i class='bi bi-pencil'></i></button>
                            <button type='button' class='btn btn-danger btn-sm deleteEventButton' data-uc_no='" . $row['uc_no'] . "'><i class='bi bi-trash'></i></button>
                            <button type='button' class='btn generateCalendarButton ' id='gen-cal' data-uc_no='" . $row['uc_no'] . "' data-calendar-type='" . $row['uc_calendar_type'] . "'>Generate Calendar</button>
                          </td>";
                        echo "</tr>";
                    }
                } else {
                    // Display message if no records are found
                    echo "<tr><td colspan='11'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for adding/editing a user calendar event -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Modal header with title and close button -->
                    <!-- <h2 class="modal-title" id="eventModalLabel">Add</h2> -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Iframe to load the event update form -->
                    <iframe id="eventIframe" src="add_update_modal.php" style="width: 100%; height: 400px; border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for uploading images -->
    <div class="modal fade" id="uploadImageModal" tabindex="-1" aria-labelledby="uploadImageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Modal header with title and close button -->
                    <h2 class="modal-title" id="uploadImageModalLabel">Your Images</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Iframe to load the image upload form -->
                    <iframe id="uploadImageIframe" src="upload_img_modal.php" style="width: 100%; height: 400px; border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Event handler for add event button click
            $('#addEventButton').on('click', function() {
                $('#eventModalLabel').text('Add'); // Change modal title to 'Add'
                $('#eventIframe').attr('src', 'add_update_modal.php'); // Set iframe src to add event form
            });

            // Event handler for edit button click
            $(document).on('click', '.editEventButton', function() {
                var uc_no = $(this).data('uc_no'); // Get event number from data attribute
                $('#eventModalLabel').text('Edit'); // Change modal title to 'Edit'
                $('#eventIframe').attr('src', 'add_update_modal.php?uc_no=' + uc_no); // Set iframe src to edit event form with event number parameter
            });

            // Event handler for delete button click
            $(document).on('click', '.deleteEventButton', function() {
                var uc_no = $(this).data('uc_no'); // Get event number from data attribute
                // Confirm deletion
                if (confirm("Are you sure you want to delete this event?")) {
                    $.ajax({
                        url: 'delete.php', // URL to delete event script
                        type: 'POST',
                        data: JSON.stringify({
                            uc_no: uc_no // Send event number in request body
                        }),
                        contentType: 'application/json', // Set content type to JSON
                        success: function(resp_data) {
                            // Check response data from server
                            var res = JSON.parse(resp_data); // Parse JSON response data
                            if (res.status === 'success') {
                                updateEventTable(); // Refresh the table after deletion
                            } else {
                                alert('Error deleting event: ' + res.message);
                            }
                        },
                    });
                }
            });

            // Event handler for generate calendar button click
            $(document).on('click', '.generateCalendarButton', function() {
                var uc_no = $(this).data('uc_no'); // Get event number from data attribute
                var calendarType = $(this).data('calendar-type'); // Get calendar type from data attribute
                var userId = $(this).data('usr_id'); // Get user id from data attribute

                // Open the calendar template file in a new tab based on calendar type and user id
                window.open('../cal_design/' + calendarType + '.php?uc_no=' + uc_no + '&usr_id=' + userId, '_blank');
            });




            // Event handler for upload image button click
            $(document).on('click', '.uploadImageButton', function() {
                var uc_no = $(this).data('uc_no'); // Get event number from data attribute
                $('#uploadImageModalLabel').text('Your Images'); // Change modal title to 'Upload Images'
                $('#uploadImageIframe').attr('src', 'upload_img_modal.php?uc_no=' + uc_no); // Set iframe src to upload image form with event number parameter
            });

            // // Event handler for when the upload image modal is hidden (closed)
            // $('#uploadImageModal').on('hidden.bs.modal', function() {
            //     // Refresh image column for all rows
            //     $('[id^=image-column]').each(function() {
            //         var uc_no = this.id.split('-')[2]; // Extract uc_no from id
            //         $.ajax({
            //             url: 'upload_img_modal.php', // URL to fetch updated images for specific uc_no
            //             type: 'POST',
            //             data: {
            //                 uc_no: uc_no
            //             }, // Send uc_no as data
            //             success: function(data) {
            //                 $('#image-column-' + uc_no).html(data); // Update specific image column with new data
            //             },
            //             error: function() {
            //                 alert('Error fetching images');
            //             }
            //         });
            //     });
            // });

            // Function to update the event table
            window.updateEventTable = function() {
                $.ajax({
                    url: 'index.php', // URL to fetch updated event table
                    type: 'GET',
                    success: function(data) {
                        var newTableBody = $(data).find('#eventTableBody').html(); // Extract the new table body from the response
                        $('#eventTableBody').html(newTableBody); // Update the table body with the new data
                    },
                    error: function() {
                        alert('Error fetching data'); // Alert on error
                    }
                });
            };

            // Function to show a message in the message div
            window.showMessage = function(message, type) {
                var messageDiv = $('#message'); // Get the message div
                messageDiv.removeClass('d-none alert-success alert-danger') // Remove existing classes
                    .addClass('alert-' + type) // Add the alert class based on the message type (success or danger)
                    .text(message); // Set the message text
                setTimeout(function() {
                    messageDiv.addClass('d-none'); // Hide the message div after 3 seconds
                }, 3000);
            };



            //search 
            $('#searchForm').submit(function(event) {
                event.preventDefault();
                updateEventTable();
            });

            window.updateEventTable = function() {
                var searchInput = $('#searchInput').val();
                $.ajax({
                    url: 'index.php',
                    type: 'POST',
                    data: {
                        searchInput: searchInput
                    },
                    success: function(data) {
                        var newTableBody = $(data).find('#eventTableBody').html();
                        $('#eventTableBody').html(newTableBody);
                    },
                    error: function() {
                        alert('Error fetching data');
                    }
                });
            };
        });
    </script>

    <!-- Bootstrap JS  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>

<?php
include '../nav/sidebar.php';
// Close the database connection
$conn->close();
?>