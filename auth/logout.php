<?php
 // This line includes the 'db_connection.php' file. This file typically contains the code needed to establish a connection to the database.
 include '../db_connection.php';

 // This function starts a new session or resumes an existing session.
 session_start();

 // This function frees all session variables currently registered.
 session_unset();

 // This function destroys all data registered to a session, effectively logging the user out.
 session_destroy();

 // This line sends a raw HTTP header to the browser, redirecting the user to 'login.php'.
 header('Location: login.php');

 // This function is used to terminate the script execution after the header() function call.
 exit();
?>
