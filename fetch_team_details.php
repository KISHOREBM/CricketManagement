<?php

$servername = "localhost";
$username = "hari";
$password = "hari@1234";
$dbname = "cricket";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get team name from query parameter
$teamName = $conn->real_escape_string($_GET['team']);


$sql = "SELECT * FROM teams WHERE teamname = '$teamName'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $team = $result->fetch_assoc();
} else {
    $team = null;
}

// Return JSON-encoded data
header('Content-Type: application/json');
echo json_encode($team);

$conn->close();
?>
