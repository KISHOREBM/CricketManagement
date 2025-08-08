<?php
// Database connection
$hostname = "localhost";
$username = "hari";
$password = "hari@1234";
$database_name = "Cricket";

// Create connection
$conn = new mysqli($hostname, $username, $password, $database_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$GroundName = '';
$Location = '';
$Country = '';
$Capacity = '';
$EstablishedYear = '';
$MatchesPlayed = '';
$img = '';

// Check if a ground_id is provided via GET
if (isset($_GET['GroundID'])) {
    $ground_id = $_GET['GroundID'];

    // Prepare SQL query
    $stmt = $conn->prepare("SELECT GroundName, Location, Country, Capacity, EstablishedYear, MatchesPlayed, img FROM ground WHERE GroundID = ?");
    $stmt->bind_param("i", $ground_id);
    $stmt->execute();
    $stmt->bind_result($GroundName, $Location, $Country, $Capacity, $EstablishedYear, $MatchesPlayed, $img);
    $stmt->fetch();
    $stmt->close();
}

// Fetch all grounds for dropdown
$sql = "SELECT GroundID, GroundName FROM ground";
$result = $conn->query($sql);
$conn->close(); // Close connection

// Array to store fetched grounds
$grounds = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $grounds[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ground Details</title>
    <style>
        body {
            background-color: lightgoldenrodyellow;
            font-family: Arial, sans-serif;
        }
        .ground-list {
            list-style-type: none;
            padding: 10px;
            width: 300px;
            margin: 20px auto;
            background-color: #4f97a3;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: white;
        }
        .ground-list option {
            padding: 10px;
        }
        .ground-list option:hover {
            background-color: darkgray;
        }
        .custom-button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            background-color: lightblue;
            color: #fff;
            border: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        .custom-button:hover {
            background-color: #48d1cc;
        }
        .ground-details {
            border-radius: 8px;
            padding: 20px;
            background-color: lightyellow;
            border: 1px solid #ccc;
            margin: 20px auto;
            max-width: 700px;
        }
        .ground-details img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 10px auto;
        }
    </style>
</head>
<body>

<center><h1>Ground Details</h1></center>
<center>
<form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <select name="GroundID" class="ground-list">
        <option value="">Select Ground</option>
        <?php foreach ($grounds as $ground) : ?>
            <option value="<?php echo $ground['GroundID']; ?>" <?php echo isset($_GET['GroundID']) && $_GET['GroundID'] == $ground['GroundID'] ? 'selected' : ''; ?>>
                <?php echo $ground['GroundName']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <input type="submit" class="custom-button" value="Show Details">
</form>
</center>
<?php if (!empty($GroundName)) : ?>
    <div class="ground-details">
        <h3><?php echo $GroundName; ?></h3>
        <p><strong>Location:</strong> <?php echo $Location; ?></p>
        <p><strong>Country:</strong> <?php echo $Country; ?></p>
        <p><strong>Capacity:</strong> <?php echo $Capacity; ?></p>
        <p><strong>Established year:</strong> <?php echo $EstablishedYear; ?></p>
        <p><strong>Matches played:</strong> <?php echo $MatchesPlayed; ?></p>
        <?php if (!empty($img)) : ?>
            <img src="<?php echo $img; ?>" alt="Ground Image">
        <?php else : ?>
            <p>No image available</p>
        <?php endif; ?>
    </div>
<?php endif; ?>

</body>
</html>
