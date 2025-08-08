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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['table'])) {
    $selectedTable = $_POST['table'];

    // Handle data insertion
    if (isset($_POST['submit_data'])) {
        // Start transaction
        $conn->begin_transaction();
        
        try {
            $columns = $conn->query("SHOW COLUMNS FROM $selectedTable");
            $columnNames = [];
            $columnValues = [];
            $placeholders = [];
            
            while ($column = $columns->fetch_assoc()) {
                if ($column['Field'] != 'id') {
                    $columnNames[] = $column['Field'];
                    $columnValues[] = $_POST[$selectedTable . '_' . $column['Field']];
                    $placeholders[] = '?';
                }
            }
            
            $sql = "INSERT INTO $selectedTable (" . implode(',', $columnNames) . ") VALUES (" . implode(',', $placeholders) . ")";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(str_repeat('s', count($columnValues)), ...$columnValues);
            $stmt->execute();
            $stmt->close();
            
            // Commit transaction
            $conn->commit();
            echo "<p>Data inserted successfully.</p>";
        } catch (Exception $e) {
            // Rollback transaction on error
            $conn->rollback();
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }

        $conn->close();
        exit;
    }
} else {
    // Redirect to selection form if no table is selected
    header("Location: form_selector.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Form Generator</title>
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
            background-position: center;
            background-size:100%;
            backdrop-filter: blur(10px);
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(255,255,255,0.3);
            width: 600px;
            text-align: center;
        }
        h1, h2 {
            margin-top: 0;
            color: #333;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            text-align: left;
        }
        input[type="text"], input[type="submit"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-top: 5px;
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
        a {
            display: block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Insert</h1>
        <form action="form_generator.php" method="post">
            <h2><?php echo ucfirst($selectedTable); ?></h2>
            <?php
            $columns = $conn->query("SHOW COLUMNS FROM $selectedTable");
            while ($column = $columns->fetch_assoc()):
            ?>
                <label for="<?php echo $selectedTable . '_' . $column['Field']; ?>">
                    <?php echo ucfirst($column['Field']); ?>:
                </label>
                <input type="text" id="<?php echo $selectedTable . '_' . $column['Field']; ?>" name="<?php echo $selectedTable . '_' . $column['Field']; ?>" required>
            <?php endwhile; ?>
            <input type="hidden" name="table" value="<?php echo htmlspecialchars($selectedTable); ?>">
            <input type="submit" name="submit_data" value="Submit Data">
        </form>
        <a href="form_selector.php">Select a different table</a>
    </div>
</body>
</html>
