<?php
// Include database connection script to connect to the database
include '../db_connection.php';

// Read current user ID and user type from cookies
$curr_usr_id = isset($_COOKIE['usr_id']) ? $_COOKIE['usr_id'] : null;
$curr_usr_type = isset($_COOKIE['usr_type']) ? $_COOKIE['usr_type'] : null;

// Handle cases where the cookies are not set
if (!$curr_usr_type) {
    $curr_usr_type = 'User';
}

// Initialize search condition
$searchCondition = '';

// Check if search form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['searchInput'])) {
    $searchInput = $conn->real_escape_string($_POST['searchInput']);
    // Apply search condition based on input
    $searchCondition = "AND (usr_id LIKE '%$searchInput%' OR usr_name LIKE '%$searchInput%' )";
}

// Compose the WHERE clause based on user type and search condition
if ($curr_usr_type == "Admin") {
    $where_clause = "WHERE 1=1 $searchCondition";
} else {
    $where_clause = "WHERE usr_id='$curr_usr_id' $searchCondition";
}

// Fetch user data from the database with the WHERE clause
$sql = "SELECT usr_no, usr_id, usr_name, usr_email, usr_status, usr_type, usr_dob FROM user $where_clause";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>

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

        .container {
            max-width: 90%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: black;
            font-weight: bold;
            border-bottom: 1px solid black;
        }

        .table {
            width: 100%;
            border: 1px solid #dee2e6;
            margin-top: 20px;
        }

        .table th,
        .table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #dee2e6;
        }

        .table th {
            background-color: lightgray;
            color: black;
            border: 1px solid black;
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

        #searchForm {
            width: 350px;
            float: right;
        }

        #search-btn {
            margin-left: 5px;
        }
    </style>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container">



        <!-- Message Div -->
        <div style="text-align:center;">
            <p id="message" class="alert d-none "></p>
        </div>
        <h1>User Details</h1>

   <!-- Button to trigger modal for adding a user -->
   <?php if ($curr_usr_type == "Admin"): ?>
                    <button type="button" class="btn btn-primary" id="addUserButton" data-bs-toggle="modal" data-bs-target="#userModal">Add User</button>
                <?php endif; ?>

        <form id="searchForm" class="input-group" method="POST" action="index.php">
    
            
            <input type="text" class="form-control" placeholder="Search by Mobile No or Name" id="searchInput" name="searchInput">
            <button type="submit" class="btn btn-dark " id="search-btn"><i class="bi bi-search"></i></button>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <!-- Table headers for user details -->
                    <th>Sr.no</th>
                    <th>Mobile No</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Type</th>
                    <th>Date of Birth</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <?php
                // Check if there are any users in the database
                if ($result->num_rows > 0) {
                    // Loop through each user and display their details in the table
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['usr_no'] . "</td>";
                        echo "<td>" . $row['usr_id'] . "</td>";
                        echo "<td>" . $row['usr_name'] . "</td>";
                        echo "<td>" . $row['usr_email'] . "</td>";
                        echo "<td>" . ($row['usr_status'] ? 'Active' : 'Inactive') . "</td>";
                        echo "<td>" . $row['usr_type'] . "</td>";
                        echo "<td>" . $row['usr_dob'] . "</td>";
                        echo "<td>
                            <!-- Buttons to edit and delete user -->
                            <button type='button' class='btn btn-primary btn-sm edit-btn' data-bs-toggle='modal' data-bs-target='#userModal' data-usr_no='" . $row['usr_no'] . "'><i class='bi bi-pencil'></i></button>
                            <button type='button' class='btn btn-danger btn-sm delete-btn' data-usr_no='" . $row['usr_no'] . "'><i class='bi bi-trash'></i></button>
                          </td>";
                        echo "</tr>";
                    }
                } else {
                    // Display message if no users are found
                    echo "<tr><td colspan='9'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for adding/editing a user -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Modal header with title and close button -->
                    <h2 class="modal-title" id="userModalLabel">Add User</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Iframe to load the user update form -->
                    <iframe id="userIframe" src="add_update_modal.php" style="width: 100%; height: 400px; border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#addUserButton').on('click', function() {
                $('#userModalLabel').text('Add User');
                $('#userIframe').attr('src', 'add_update_modal.php');
            });

            $(document).on('click', '.edit-btn', function() {
                var usr_no = $(this).data('usr_no');
                $('#userModalLabel').text('Edit User');
                $('#userIframe').attr('src', 'add_update_modal.php?usr_no=' + usr_no);
            });

            $(document).on('click', '.delete-btn', function() {
                var usr_no = $(this).data('usr_no');
                if (confirm("Are you sure you want to delete this user?")) {
                    $.ajax({
                        url: 'delete.php',
                        type: 'POST',
                        data: JSON.stringify({
                            action: 'delete',
                            usr_no: usr_no
                        }),
                        contentType: 'application/json',
                        success: function(resp_data) {
                            var res = JSON.parse(resp_data);
                            if (res.status === 'success') {
                                updateUserTable();
                                showMessage('User deleted successfully', 'success');
                            } else {
                                showMessage('Error deleting user: ' + res.message, 'danger');
                            }
                        },
                        error: function(xhr, status, error) {
                            showMessage('Error: ' + error, 'danger');
                        }
                    });
                }
            });

            window.updateUserTable = function() {
                var searchInput = $('#searchInput').val();
                $.ajax({
                    url: 'index.php',
                    type: 'POST',
                    data: {
                        searchInput: searchInput
                    },
                    success: function(data) {
                        $('#userTableBody').html($(data).find('#userTableBody').html());
                    },
                    error: function() {
                        showMessage('Error fetching data', 'danger');
                    }
                });
            };

            window.showMessage = function(message, type) {
                var messageDiv = $('#message');
                messageDiv.removeClass('d-none alert-success alert-danger')
                    .addClass('alert-' + type)
                    .text(message);
                setTimeout(function() {
                    messageDiv.addClass('d-none');
                }, 3000);
            };

            $('#searchForm').submit(function(event) {
                event.preventDefault();
                updateUserTable();
            });
        });
    </script>

</body>

</html>

<?php
// Include sidebar navigation script
include '../nav/sidebar.php';
// Close the database connection
$conn->close();
?>