<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bitescan";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  echo json_encode(['error' => 'Database connection failed']);
  exit;
}

$sql = "SELECT * FROM meal_history ORDER BY timestamp DESC";
$result = $conn->query($sql);

$meals = [];

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $meals[] = $row;
  }
}

echo json_encode($meals);
$conn->close();
?>
