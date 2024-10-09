<?php
// Include the database connection file
include '../db_connection.php';



// Check if the user is logged in
if (!isset($_COOKIE['usr_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Get user information from cookies
$usr_id = $_COOKIE['usr_id'];
$usr_name = $_COOKIE['usr_name'];
$usr_type = $_COOKIE['usr_type'];

// // Display different welcome messages based on user type
// $welcome_message = '';
// $welcome_message = "Welcome $usr_name! You are logged in as a $usr_type.";

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href=" https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">


    <!-- bootstrap icon link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <style>
        @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap");

        :root {
            --header-height: 3rem;
            --nav-width: 68px;
            --first-color: black;
            --first-color-light: #AFA5D9;
            --white-color: #F7F6FB;
            --body-font: 'Nunito', sans-serif;
            --normal-font-size: 1rem;
            --z-fixed: 100;
        }

        *,
        ::before,
        ::after {
            box-sizing: border-box;
        }

        body {
            position: relative;
            margin: var(--header-height) 0 0 0;
            padding: 0 1rem;
            font-family: var(--body-font);
            font-size: var(--normal-font-size);
            transition: .5s;
        }

        a {
            text-decoration: none;
        }

        .header {
            width: 100%;
            height: var(--header-height);
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem;
            background-color: var(--white-color);
            z-index: var(--z-fixed);
            transition: .5s;
        }

        .header_toggle {
            color: var(--first-color);
            font-size: 1.5rem;
            cursor: pointer;
        }


        .l-navbar {
            position: fixed;
            top: 0;
            left: -30%;
            width: var(--nav-width);
            height: 100vh;
            background-color: var(--first-color);
            padding: .5rem 1rem 0 0;
            transition: .5s;
            z-index: var(--z-fixed);
        }

        .nav {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
        }

        .nav_logo,
        .nav_link {
            display: grid;
            grid-template-columns: max-content max-content;
            align-items: center;
            column-gap: 1rem;
            padding: .5rem 0 .5rem 1.5rem;
        }

        .nav_logo {
            margin-bottom: 2rem;
        }

        .nav_logo-icon {
            font-size: 1.25rem;
            color: var(--white-color);
        }

        .nav_logo-name {
            color: var(--white-color);
            font-weight: 700;
        }

        .nav_link {
            position: relative;
            color: var(--first-color-light);
            margin-bottom: 1.5rem;
            transition: .3s;
        }

        .nav_link:hover {
            color: var (--white-color);
        }

        .nav_icon {
            font-size: 1.25rem;
        }

        .view {
            left: 0;
        }


        .active {
            color: var(--white-color);
        }

        .active::before {
            content: '';
            position: absolute;
            left: 0;
            width: 2px;
            height: 32px;
            background-color: var(--white-color);
        }

        /* .height-100 {
            height: 100vh;
        } */

        @media screen and (min-width: 100px) {
            body {
                margin: calc(var(--header-height) + 1rem) 0 0 0;
                padding-left: calc(var(--nav-width));
            }

            .header {
                height: calc(var(--header-height) + 1rem);
                padding: 0 2rem 0 calc(var(--nav-width) + 2rem);
            }


            .l-navbar {
                left: 0;
                padding: 1rem 1rem 0 0;
            }

            .view {
                width: calc(var(--nav-width) + 156px);
            }

            .body-pd {
                padding-left: calc(var(--nav-width) + 155px);
            }
        }

    #header-toggle{
        color: white;
        font-size: 30px;
        margin-left: 10px;
        cursor: pointer;
    }
    </style>

</head>



<body id="body-pd">

    <body>
        <header class="header" id="header">
            <div class="header_toggle">
            </div>
            <div class="d-flex ml-auto">
                <div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                        <li>
                            <p class="dropdown-item"><strong>Username: <?php echo $usr_name; ?></strong></p>
                        </li>
                        <li>
                            <p class="dropdown-item"><strong>User Id: <?php echo $usr_id; ?></strong></p>
                        </li>
                        <li>
                            <p class="dropdown-item"><strong>User Type: <?php echo $usr_type; ?></strong></p>
                        </li>


                        <li><a href="../auth/logout.php" class="nav_link">
                                <i class='bx bx-log-out nav_icon'></i>
                                <span class="nav_name">Log Out</span>
                            </a></li>


                    </ul>
                </div>
            </div>
        </header>
        <div class="l-navbar" id="nav-bar">
            <nav class="nav">
                <div>
                <i class='bx bx-menu' id="header-toggle"></i>

                    <a href="#" class="nav_logo">
                        <i class='bx bx-layer nav_logo-icon'></i>
                        <span class="nav_logo-name">
                            <h3>Calendar<br> Generator</h3>
                        </span>
                    </a>
                    <div class="nav_list">
                        <a href="../dashboard/index.php" class="nav_link active">
                            <i class='bx bx-grid-alt nav_icon'></i>
                            <span class="nav_name">Dashboard</span>
                        </a>
                        <a href="../user/index.php" class="nav_link active">
                            <i class='bx bx-user nav_icon'></i>
                            <span class="nav_name">User Details</span>
                        </a>
                        <a href="../user_calendar/index.php" class="nav_link active">
                            <i class='bx bx-message-square-detail nav_icon'></i>
                            <span class="nav_name">User Calendar </span>
                        </a>
                    </div>
                </div>
                <!-- <a href="../auth/logout.php" class="nav_link">
                    <i class='bx bx-log-out nav_icon'></i>
                    <span class="nav_name">SignOut</span>
                </a> -->
            </nav>
        </div>
        <!--Container Main start-->
        <div class="height-100 ">

        </div>
        <!--Container Main end-->
    </body>


    <script>
        document.addEventListener("DOMContentLoaded", function(event) {

            const viewNavbar = (toggleId, navId, bodyId, headerId) => {
                const toggle = document.getElementById(toggleId),
                    nav = document.getElementById(navId),
                    bodypd = document.getElementById(bodyId),
                    headerpd = document.getElementById(headerId)

                // Validate that all variables exist
                if (toggle && nav && bodypd && headerpd) {
                    toggle.addEventListener('click', () => {
                        // view navbar
                        nav.classList.toggle('view')
                        // change icon
                        toggle.classList.toggle('bx-x')
                        // add padding to body
                        bodypd.classList.toggle('body-pd')
                        // add padding to header
                        headerpd.classList.toggle('body-pd')
                    })
                }
            }

            viewNavbar('header-toggle', 'nav-bar', 'body-pd', 'header')

            /*===== LINK ACTIVE =====*/
            const linkColor = document.querySelectorAll('.nav_link')

            function colorLink() {
                if (linkColor) {
                    linkColor.forEach(l => l.classList.remove('active'))
                    this.classList.add('active')
                }
            }
            linkColor.forEach(l => l.addEventListener('click', colorLink))

            // Your code to run since DOM is loaded and ready
        });
    </script>



</body>

</html>