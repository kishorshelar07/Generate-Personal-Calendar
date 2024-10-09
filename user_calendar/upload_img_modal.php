<?php
// Include database connection script and common includes
include '../db_connection.php';
include '../common_include.php';

// Get event number from query parameter
$uc_no = $_GET['uc_no'];

// Fetch usr_id from the user_calendar table
$sql_usr_id = "SELECT usr_id FROM user_calendar WHERE uc_no='$uc_no'";
$result_usr_id = $conn->query($sql_usr_id);

if (!$result_usr_id) {
    die("Error fetching user ID: " . $conn->error);
}

$row_usr_id = $result_usr_id->fetch_assoc();
if (!$row_usr_id) {
    die("User ID not found for uc_no: $uc_no");
}

$usr_id = $row_usr_id['usr_id'];


// Fetch user name from the users table using usr_id
$sql_user = "SELECT usr_id FROM user WHERE usr_id='$usr_id'";
$result_user = $conn->query($sql_user);

if (!$result_user) {
    die("Error fetching user name: " . $conn->error);
}

$row_user = $result_user->fetch_assoc();
if (!$row_user) {
    die("User not found for usr_id: $usr_id");
}

$usr_id = $row_user['usr_id'];
$prefix = substr($usr_id, 0, 6); // Get the first 6 characters of usr_id

// Function to generate a unique 4-character identifier
function generateUniqueID() {
    return substr(uniqid(), -4); // Get the last 4 characters of uniqid()
}

// Fetch images for the event from the database
$sql = "SELECT uc_img_csv FROM user_calendar WHERE uc_no='$uc_no'";
$result = $conn->query($sql);

if (!$result) {
    die("Error fetching images: " . $conn->error);
}

$row = $result->fetch_assoc();
$images = !empty($row['uc_img_csv']) ? explode(', ', $row['uc_img_csv']) : [];
$image_limit = 24;

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Check if the request method is POST
    if (isset($_FILES['new_images'])) { // Check if new images are uploaded
        // Handle multiple image uploads
        $uploaded_files = $_FILES['new_images'];
        $total_files = count($uploaded_files['name']);
        $current_image_count = count($images);

        if ($current_image_count + $total_files > $image_limit) {
            // Redirect back with error message if limit exceeded
            header("Location: upload_img_modal.php?uc_no=$uc_no&error=limit_exceeded");
            exit();
        }

        for ($i = 0; $i < $total_files; $i++) {
            $target_dir = "../uploads/"; // Directory where images will be saved
            $temp_name = $uploaded_files['tmp_name'][$i]; // Temporary file name
            $extension = pathinfo($uploaded_files['name'][$i], PATHINFO_EXTENSION); // Get file extension
            $unique_name = $prefix . '_' . generateUniqueID() . '.' . $extension; // Generate a unique name with prefix and 4-character identifier
            $target_file = $target_dir . basename($unique_name); // Full path to save the file

            if (move_uploaded_file($temp_name, $target_file)) { // Move the uploaded file to the target directory
                // Append new image to existing images array
                $images[] = $unique_name; // Store only the unique name
            }
        }
        $images_csv = implode(', ', $images); // Convert the images array back to CSV format

        // Update the database with the new images CSV
        $sql = "UPDATE user_calendar SET uc_img_csv='$images_csv' WHERE uc_no='$uc_no'";
        if (!$conn->query($sql)) {
            die("Error updating images: " . $conn->error);
        }

        // Reload the page to update the modal with the new images
        header("Location: upload_img_modal.php?uc_no=$uc_no");
        exit();
    }

    if (isset($_POST['delete_image'])) { // Check if an image deletion request is received
        // Handle image deletion
        $image_to_delete = $_POST['delete_image'];
        if (($key = array_search($image_to_delete, $images)) !== false) {
            unset($images[$key]); // Remove the image from the array
            unlink("../uploads/" . $image_to_delete); // Delete the image file from the server
        }
        $images_csv = implode(', ', $images); // Convert the updated images array back to CSV format

        // Update the database with the remaining images CSV
        $sql = "UPDATE user_calendar SET uc_img_csv='$images_csv' WHERE uc_no='$uc_no'";
        if (!$conn->query($sql)) {
            die("Error updating images: " . $conn->error);
        }

        // Reload the page to update the modal with the remaining images
        header("Location: upload_img_modal.php?uc_no=$uc_no");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        /* Styles for uploaded image preview container */
        .uploaded-image-preview img {
            height: 150px;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .uploaded-image-preview {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
        }

        .uploaded-image-preview > div {
            flex: 0 0 auto;
            position: relative;
        }

        .new-image-preview img {
            height: 70px;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .new-image-preview {
            display: flex;
            flex-wrap: wrap;
            max-height: 100px;
            overflow-y: auto;
        }

        .new-image-preview > div {
            flex: 1 1 calc(25% - 10px);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .delete-button {
            display: none;
            position: absolute;
            top: 5px;
            right: 5px;
            cursor: pointer;
            background-color: rgba(255, 255, 255, 0.8);
            border: none;
            padding: 5px;
            border-radius: 50%;
        }

        .uploaded-image-preview > div:hover .delete-button {
            display: block;
        }

        .upload-form-container {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 600px;
            background-color: white;
            padding: 10px;
            box-shadow: 0px -2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .upload-form-container form {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .upload-form-container.fixed {
            bottom: auto;
            top: calc(100% - 100px);
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <h5>Uploaded Images (<span id="imageCount"><?= count($images) ?></span> of <?= $image_limit ?>)</h5>
        <div class="uploaded-image-preview" id="uploadedImages">
            <?php
            foreach ($images as $image) {
                echo "<div class='d-inline-block position-relative'>";
                echo "<img src='../uploads/$image' alt='Uploaded Image'>";
                echo "<button class='btn btn-sm delete-button' data-image='$image'><i class='bi bi-x-circle'></i></button>";
                echo "</div>";
            }
            ?>
        </div>
        <?php if (isset($_GET['error']) && $_GET['error'] == 'limit_exceeded'): ?>
            <div class="alert alert-danger mt-3">
                You can upload a maximum of 24 images.
            </div>
        <?php endif; ?>
    </div>
    <br><br><br><br>
    <div class="upload-form-container" id="uploadFormContainer">
        <div class="new-image-preview" id="imagePreview"></div>
        <form id="uploadForm" action="upload_img_modal.php?uc_no=<?= $uc_no ?>" method="POST" enctype="multipart/form-data">
            <div class="me-3">
                <label for="new_images" class="form-label">Select Images to Upload:</label>
                <input type="file" class="form-control" name="new_images[]" id="new_images" multiple>
            </div>
            <button type="submit" class="btn btn-primary">Upload Images</button>
        </form>
    </div>

    <!-- jQuery for handling AJAX requests -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS for styling -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Preview selected images before upload
            $('#new_images').on('change', function() {
                const preview = $('#imagePreview');
                preview.empty();
                const files = this.files;
                if (files) {
                    [].forEach.call(files, readAndPreview);
                }

                function readAndPreview(file) {
                    if (!/\.(jpe?g|png|gif)$/i.test(file.name)) {
                        return alert(file.name + " is not an image");
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const image = new Image();
                        image.src = e.target.result;
                        preview.append(image);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Handle image deletion via AJAX
            $(document).on('click', '.delete-button', function() {
                const image = $(this).data('image');
                if (confirm("Are you sure you want to delete this image?")) {
                    $.post('upload_img_modal.php?uc_no=<?= $uc_no ?>', {
                        delete_image: image
                    }, function() {
                        location.reload();
                    });
                }
            });

            // Update image count on page load
            updateImageCount();

            function updateImageCount() {
                const imageCount = $('#uploadedImages img').length;
                $('#imageCount').text(imageCount);
            }

            // Update image count after deleting an image
            $(document).on('click', '.delete-button', function() {
                setTimeout(updateImageCount, 500); // Wait for 500ms before updating the count to allow for image deletion
            });
        });
    </script>
</body>

</html>
