<?php

$servername = "localhost";
$username = "root";
$password = "";
$database_name = "car_db"; // pangalan ng database

$conn = new mysqli($servername, $username, $password, $database_name);

if ($conn->connect_error) {
    die("Connection Failed: " .  $conn->connect_error);
}
