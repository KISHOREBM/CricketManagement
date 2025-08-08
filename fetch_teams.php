<?php
// Database connection
$servername = "localhost";
$username = "hari";
$password = "hari@1234";
$dbname = "cricket";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch team names
$sql = "SELECT teamname FROM teams";
$result = $conn->query($sql);

$teams = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $teams[] = $row['teamname'];
    }
}

// Return JSON-encoded data
header('Content-Type: application/json');
echo json_encode($teams);

$conn->close();
?>
