<?php
include '../db_connection.php';

$usr_no = isset($_GET['usr_no']) ? $_GET['usr_no'] : null;
$user_rec = null;

if ($usr_no) {
    $sql = "SELECT * FROM user WHERE usr_no='$usr_no'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user_rec = $result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $usr_no ? 'Edit User' : 'Add User'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <h1><?php echo $usr_no ? 'Edit User' : 'Add User'; ?></h1>
        <form id="userForm">
            <input type="hidden" name="usr_no" value="<?php echo $usr_no; ?>">
            <div class="mb-3">
                <label for="usr_id" class="form-label">Mobile No</label>
                <input type="text" class="form-control" id="usr_id" name="usr_id" value="<?php echo $user_rec['usr_id'] ?? ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="usr_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="usr_name" name="usr_name" value="<?php echo $user_rec['usr_name'] ?? ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="usr_pass" class="form-label">Password</label>
                <input type="password" class="form-control" id="usr_pass" name="usr_pass" value="<?php echo $user_rec['usr_pass'] ?? ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="usr_status" class="form-label">Status</label>
                <select class="form-select" id="usr_status" name="usr_status" required>
                    <option value="1" <?php echo isset($user_rec['usr_status']) && $user_rec['usr_status'] == '1' ? 'selected' : ''; ?>>Active</option>
                    <option value="0" <?php echo isset($user_rec['usr_status']) && $user_rec['usr_status'] == '0' ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="usr_type" class="form-label">Type</label>
                <select class="form-control" id="usr_type" name="usr_type" required>
                    <option value="">Select Type</option>
                    <option value="Admin" <?php echo isset($user_rec['usr_type']) && $user_rec['usr_type'] == 'Admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="User" <?php echo isset($user_rec['usr_type']) && $user_rec['usr_type'] == 'User' ? 'selected' : ''; ?>>User</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="usr_dob" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="usr_dob" name="usr_dob" value="<?php echo $user_rec['usr_dob'] ?? ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="usr_email" class="form-label">Email</label>
                <input type="email" class="form-control" id="usr_email" name="usr_email" value="<?php echo $user_rec['usr_email'] ?? ''; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary"><?php echo $usr_no ? 'Update' : 'Add'; ?> User</button>
        </form>
    </div>

  
    <script>
    // This script is executed when the HTML document is fully loaded.
    $(document).ready(function() {
        // Handle form submission for adding/updating a user
        $('#userForm').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Serialize the form data into an array and convert it into an object
            var formData = $(this).serializeArray();
            var data = {};

            // Convert serialized array to an object
            formData.forEach(function(item) {
                data[item.name] = item.value;
            });

            // Send an AJAX request to add/update the user
            $.ajax({
                url: '<?php echo $usr_no ? 'user_update_action.php' : 'user_add_action.php'; ?>', // Dynamic URL based on action
                type: 'POST',
                data: JSON.stringify(data), // Convert data to JSON string
                contentType: 'application/json', // Set content type to JSON
                success: function(resp_data) {
                    var res = JSON.parse(resp_data); // Parse JSON response
                    if (res.status === 'success') {
                        window.parent.updateUserTable(); // Update parent window's user table
                        window.parent.showMessage(res.message, 'success'); // Show success message
                        window.parent.$('#userModal').modal('hide'); // Hide the modal
                    } else {
                        alert('Error: ' + res.message); // Show error message
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + error); // Show AJAX error message
                }
            });
        });
    });
</script>

</body>

</html>

<?php
$conn->close();
?>