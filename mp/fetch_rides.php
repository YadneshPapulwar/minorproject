<?php
header('Content-Type: application/json');

$host = 'localhost'; // Your database host
$dbname = 'carpool'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT * FROM rides"); // Adjust the table name if necessary
    $rides = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($rides);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error fetching rides: ' . $e->getMessage()]);
}
