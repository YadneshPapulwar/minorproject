<?php
// Database configuration
$host = 'localhost'; // Your database host
$user = 'root'; // Your database username
$password = ''; // Your database password
$database = 'carpool'; // Your database name

// Create a connection
$conn = new mysqli($host, $user, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the raw POST data
$data = file_get_contents("php://input");

// Decode the JSON data
$rideData = json_decode($data, true);

// Check if data is valid
if (isset($rideData['start_lat'], $rideData['start_lng'], $rideData['end_lat'], $rideData['end_lng'], $rideData['start_datetime'], $rideData['driver_name'], $rideData['passenger_count'], $rideData['phone'], $rideData['vehicle_type'], $rideData['estimated_price'])) {

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO rides (start_lat, start_lng, end_lat, end_lng, start_datetime, driver_name, passenger_count, phone, vehicle_type, estimated_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Bind parameters
    $stmt->bind_param("ddssssiiss", 
        $rideData['start_lat'],
        $rideData['start_lng'],
        $rideData['end_lat'],
        $rideData['end_lng'],
        $rideData['start_datetime'],
        $rideData['driver_name'],
        $rideData['passenger_count'],
        $rideData['phone'],
        $rideData['vehicle_type'],
        $rideData['estimated_price']
    );

    // Execute the statement
    if ($stmt->execute()) {
        // Return success response
        echo json_encode(['success' => true]);
    } else {
        // Return error response
        echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
    }

    // Close the statement
    $stmt->close();
} else {
    // Return error response if data is invalid
    echo json_encode(['success' => false, 'message' => 'Invalid data received']);
}

// Close the database connection
$conn->close();
?>
