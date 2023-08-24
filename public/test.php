<?php
phpinfo();
error_reporting(E_ALL);
ini_set("display_errors", 1);

$servername = "localhost";
$database = "dinxstud_marriagehallsmanagementDB";
$username = "dinxstud_fanomihalls";
$password = "CanadaHalls@2021";

// Create connection

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully";
}

mysqli_close($conn);

?>