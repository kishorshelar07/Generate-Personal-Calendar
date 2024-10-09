<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="icon" type="image/png" href="../img/favicon.png">

    <!-- Link to Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        /* Set height to 100% for html and body to occupy full screen */
        html, body {
            height: 100%;
        }
        /* Center the login form container */
        .global-container {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('https://img.freepik.com/free-photo/painting-mountain-lake-with-mountain-background_188544-9126.jpg?size=626&ext=jpg&ga=GA1.1.1141335507.1718755200&semt=sph');
            background-repeat: no-repeat;
            background-size: cover;
        }
        /* Style for the login form */
        .login-form {
            width: 330px;
            margin: 20px;
            padding: 15px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        /* Styling for the card title */
        .card-title {
            font-weight: 300;
        }
        /* Button styling */
        .btn {
            font-size: 14px;
            margin-top: 20px;
        }
        /* Center align the sign-up section */
        .sign-up {
            text-align: center;
            padding: 20px 0 0;
        }
        /* Style for the alert messages */
        .alert {
            margin-bottom: -30px;
            font-size: 13px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <!-- Global container for the form -->
    <div class="global-container">
        <!-- Card container for the login form -->
        <div class="card login-form">
            <div class="card-body">
                <h3 class="card-title text-center">Log in</h3>
                <div class="card-text">
                    <!-- Alert for error messages -->
                    <div id="alertPlaceholder"></div>
                    <!-- Login form -->
                    <form id="loginForm">
                        <div class="form-group">
                            <label>Enter Your Mobile Number</label>
                            <input type="text" class="form-control form-control-sm" id="usr_id" name="usr_id" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control form-control-sm" id="usr_pass" name="usr_pass" required>
                            <a href="#" style="float:right;font-size:12px;">Forgot password?</a>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                        <div class="sign-up">
                            Don't have an account? <a href="registration.php">Sign up</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Add event listener for form submission
        document.getElementById("loginForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent default form submission

            var formData = $(this).serializeArray(); // Serialize form data
            var data = {}; // Initialize an empty object

            formData.forEach(function(item) {
                data[item.name] = item.value; // Convert form data array to an object
            });

            // Send an AJAX POST request to login_action.php
            $.ajax({
                url: 'login_action.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data), // Send the data as a JSON string
                success: function(response) {
                    if (response.status === 'success') {
                        // Set cookies for user ID, name, and type if login is successful 30 days
                        setCookie('usr_id', response.usr_id, 30);
                        setCookie('usr_name', response.usr_name, 30);
                        setCookie('usr_type', response.usr_type, 30);
                        // Redirect to the dashboard
                        window.location.href = '../dashboard/index.php';
                    } else {
                        // Display an error message if login fails
                        showAlert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Display an error message if AJAX request fails
                    showAlert('AJAX request failed: ' + error);
                }
            });
        });

        // Function to set a cookie
        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000)); // Set expiration date
                expires = "; expires=" + date.toUTCString(); // Convert to UTC string
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/"; // Set the cookie
        }

        // Function to show alert messages
        function showAlert(message) {
            var alertPlaceholder = document.getElementById('alertPlaceholder');
            var wrapper = document.createElement('div');
            wrapper.innerHTML = '<div class="alert alert-danger alert-dismissible" role="alert">' + 
                message + 
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            alertPlaceholder.append(wrapper);
        }
    </script>
    <!-- Include Bootstrap JS for interactive components -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
