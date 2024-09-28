<?php
// Database connection details
$servername = "localhost";  // Adjust if your database server is different
$username = "root";         // Your database username
$password = "";             // Your database password
$dbname = "carpool";        // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch rides from the database
$sql = "SELECT id, start_lat, start_lng, end_lat, end_lng, start_datetime FROM rides";
$result = $conn->query($sql);

// Create an array to hold ride data
$rides = [];

if ($result->num_rows > 0) {
    // Fetch each ride and add to the array
    while($row = $result->fetch_assoc()) {
        $rides[] = $row;
    }
}

// Return the ride data in JSON format
header('Content-Type: application/json');
echo json_encode($rides);

// Close the database connection
$conn->close();
?>
