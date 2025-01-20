<?php
$host = 'localhost';  // Usually 'localhost' unless using a remote database
$username = 'root';  // Replace with your MySQL username
$password = '';  // Replace with your MySQL password
$dbname = 'pengukuran_db';    // Replace with the name of your database

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>