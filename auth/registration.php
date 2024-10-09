<?php
include "../db_connection.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Form</title>

  <link rel="icon" type="image/png" href="../img/favicon.png">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <style>
    /* colors */
    :root {
      --color-governor-bay-approx: rgba(57, 49, 175, 1);
      --color-bright-turquoise-approx: rgba(0, 198, 255, 1);
      --white: #fff;
      --color-alabaster-approx: #f8f9fa;
      --color-ship-gray-approx: #383d41;
      --color-science-blue-approx: #0062cc;
      --color-abbey-approx: #495057;
    }

    .register {
      background: linear-gradient(to right,
          var(--color-governor-bay-approx) 0,
          var(--color-bright-turquoise-approx) 100%);
      margin-top: 3%;
      padding: 3%;
      overflow: hidden;
    }

    .register .register-form {
      padding: 10%;
      margin-top: 10%;
    }

    @media (max-width: 991px) {
      .register .register-form {
        margin-top: 16%;
      }
    }

    @media (max-width: 667px) {
      .register .register-form {
        margin-top: 20%;
      }
    }

    .register .nav-tabs {
      margin-top: 3%;
      border: none;
      background: var(--color-science-blue-approx);
      border-radius: 1.5rem;
      width: 28%;
      float: right;
    }

    @media (max-width: 991px) {
      .register .nav-tabs {
        width: 33%;
        margin-top: 8%;
      }
    }

    .register .nav-tabs .nav-link {
      padding: 2%;
      height: 34px;
      font-weight: 600;
      color: var(--white);
      border-top-right-radius: 1.5rem;
      border-bottom-right-radius: 1.5rem;
    }

    .register .nav-tabs .nav-link:hover {
      border: none;
    }

    .register .nav-tabs .nav-link.active {
      width: 100px;
      color: var(--color-science-blue-approx);
      border: 2px solid var(--color-science-blue-approx);
      border-top-left-radius: 1.5rem;
      border-bottom-left-radius: 1.5rem;
    }

    .register-left {
      text-align: center;
      color: var(--white);
      margin-top: 4%;
    }

    .register-left input {
      border: none;
      border-radius: 1.5rem;
      padding: 2%;
      width: 60%;
      background: var(--color-alabaster-approx);
      font-weight: bold;
      color: var(--color-ship-gray-approx);
      margin-top: 30%;
      margin-bottom: 3%;
      cursor: pointer;
    }

    .register-left img {
      margin-top: 15%;
      margin-bottom: 5%;
      width: 25%;
      animation: mover 1s infinite alternate;
    }

    .register-left p {
      font-weight: lighter;
      padding: 12%;
      margin-top: -9%;
    }

    .register-right {
      background: var(--color-alabaster-approx);
      border-top-left-radius: 10% 50%;
      border-bottom-left-radius: 10% 50%;
    }

    @-webkit-keyframes mover {
      0% {
        transform: translateY(0);
      }

      100% {
        transform: translateY(-20px);
      }
    }

    @keyframes mover {
      0% {
        transform: translateY(0);
      }

      100% {
        transform: translateY(-20px);
      }
    }

    .btnRegister {
      float: right;
      margin-top: 10%;
      border: none;
      border-radius: 1.5rem;
      padding: 2%;
      background: var(--color-science-blue-approx);
      color: var(--white);
      font-weight: 600;
      width: 50%;
      cursor: pointer;
    }

    .register-heading {
      text-align: center;
      margin-top: 8%;
      margin-bottom: -15%;
      color: var(--color-abbey-approx);
    }

    @media (max-width: 991px) {
      .register-heading {
        font-size: 1.5rem;
      }
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <div class="user-registration">
    <div class="container register">
      <div class="row">
        <div class="col-md-3 register-left">
          <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt="" />
          <h3>Welcome</h3>
          <button class="btn btn-light mb-4"><a href="../auth/login.php" style="text-decoration: none; color: #333;">Log in</a></button>
        </div>
        <div class="col-md-9 register-right">
          <div class="container mt-3">
            <form id="signup-form">
              <div class="row jumbotron box8">
                <div class="mb-4">
                  <h2 class="text-center text-info">User Registration Form</h2>
                </div>

                <div class="form-group col-sm-6">
                  <label>Full Name</label>
                  <input type="text" class="form-control" name="usr_name" id="usr_name" placeholder="Full name of user..." required>
                </div>

                <div class="form-group col-sm-6">
                  <label for="name-f"> Mobile Number</label>
                  <input type="text" class="form-control" name="usr_id" id="usr_id" placeholder="Enter your mobile number..." required>
                </div>

                <div class="form-group col-sm-6">
                  <label>Email Id</label>
                  <input type="email" name="usr_email" class="form-control" id="usr_email" placeholder="Enter your email." required>
                </div>

                <div class="form-group col-sm-6">
                  <label>Date Of Birth</label>
                  <input type="date" name="usr_dob" class="form-control" id="usr_dob" required>
                </div>

                <div class="form-group col-sm-6">
                  <label>Password</label>
                  <input type="password" name="usr_pass" class="form-control" id="usr_pass" required>
                </div>

                <div class="form-group col-sm-6">
                  <label>Confirm Password:</label>
                  <input type="password" id="cnf_pass" name="cnf_pass" class="form-control" required>
                  <span id="message" class="error-message"></span>
                </div>

                <div class="form-group col-sm-6">
                  <label>Gender:</label>
                  <select class="form-control" name="usr_gender" id="usr_gender" required>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                  </select>
                </div>

                <div class="col-sm-12 form-group mt-3 text-center w-4">
                  <button class="btn btn-primary submit-btn" type="submit" style="width: 150px;margin-top:20px; margin-bottom: 20px;">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $('#signup-form').on('submit', function(event) {
        event.preventDefault();

        var password = $('#usr_pass').val();
        var confirmPassword = $('#cnf_pass').val();
        var message = $('#message');

        if (password !== confirmPassword) {
          message.text('Passwords do not match!');
          return;
        } else {
          message.text('');
        }

        var formData = $(this).serializeArray();
        var data = {};

        formData.forEach(function(item) {
          data[item.name] = item.value;
        });

        $.ajax({
          url: 'add_action.php',
          type: 'POST',
          contentType: 'application/json',
          data: JSON.stringify(data),
          success: function(response) {
            alert('User registered successfully!');
            window.location.href = '../auth/login.php';
          },
          error: function(xhr, status, error) {
            alert('Registration failed: ' + error);
          }
        });
      });

      $('#cnf_pass').on('keyup', function() {
        if ($('#usr_pass').val() == $('#cnf_pass').val()) {
          $('#message').html('Matching').css('color', 'green');
        } else {
          $('#message').html('Not Matching').css('color', 'red');
        }
      });
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
