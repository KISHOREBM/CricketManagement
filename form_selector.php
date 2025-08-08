<?php
// Database credentials
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

// Fetch tables
$result = $conn->query("SHOW TABLES");
$tables = [];
while ($row = $result->fetch_array()) {
    $tables[] = $row[0];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Entity</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url("pl.jpg");
            backdrop-filter: blur(10px);
            background-position: center;
            background-size: 100%;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
            width: 300px;
            text-align: center;
        }
        h1 {
            margin-top: 0;
            color: #333;
        }
        select, input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Select Table</h1>
        <form action="form_generator.php" method="post">
            <label for="table">Select a table:</label>
            <select id="table" name="table" required>
                <option value="">Select</option>
                <?php foreach ($tables as $table): ?>
                    <option value="<?php echo htmlspecialchars($table); ?>"><?php echo htmlspecialchars($table); ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Select Table">
        </form>
    </div>
</body>
</html>
