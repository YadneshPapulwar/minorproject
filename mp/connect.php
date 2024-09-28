<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carpool";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$data = json_decode(file_get_contents('php://input'), true);

$startLat = $data['startLat'];
$startLng = $data['startLng'];
$endLat = $data['endLat'];
$endLng = $data['endLng'];
$startDateTime = $data['startDateTime'];
$stmt = $conn->prepare("INSERT INTO rides (start_lat, start_lng, end_lat, end_lng, start_datetime) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ddsss", $startLat, $startLng, $endLat, $endLng, $startDateTime);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
