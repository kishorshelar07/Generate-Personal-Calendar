<?php
// formate for connect database
$servername = "cloudserver5.citpune.com";
$username = "dbuser_kishor";
$password = "dbuser_kishor@citpune1234#";
$dbname = "dbCALENDAR";

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "dbcalendar";




// creat connection
$conn = new mysqli($servername, $username, $password, $dbname);


// Check Connection 
if ($conn->connect_error) {
    die("connection faild:" . $conn->connect_error);
} else {
    echo "";
}

?>