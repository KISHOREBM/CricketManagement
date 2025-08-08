<?php
// Database credentials
$servername = "localhost"; 
$username = "hari";        
$password = "hari@1234";            

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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Start transaction
    $conn->begin_transaction();
    
    try {
        foreach ($tables as $table) {
            $columns = $conn->query("SHOW COLUMNS FROM $table");
            $columnNames = [];
            $columnValues = [];
            $placeholders = [];
            
            while ($column = $columns->fetch_assoc()) {
                if ($column['Field'] != 'id') {
                    $columnNames[] = $column['Field'];
                    $columnValues[] = $_POST[$table . '_' . $column['Field']];
                    $placeholders[] = '?';
                }
            }
            
            $sql = "INSERT INTO $table (" . implode(',', $columnNames) . ") VALUES (" . implode(',', $placeholders) . ")";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(str_repeat('s', count($columnValues)), ...$columnValues);
            $stmt->execute();
            $stmt->close();
        }
        
        // Commit transaction
        $conn->commit();
        echo "Data inserted successfully.";
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Form Generator</title>
</head>
<body>
    <h1>Dynamic Form Generator</h1>
    <form action="form_generator.php" method="post">
        <?php foreach ($tables as $table): ?>
            <h2><?php echo ucfirst($table); ?></h2>
            <?php
            $columns = $conn->query("SHOW COLUMNS FROM $table");
            while ($column = $columns->fetch_assoc()):
            ?>
                <label for="<?php echo $table . '_' . $column['Field']; ?>">
                    <?php echo ucfirst($column['Field']); ?>:
                </label>
                <input type="text" id="<?php echo $table . '_' . $column['Field']; ?>" name="<?php echo $table . '_' . $column['Field']; ?>" required>
                <br><br>
            <?php endwhile; ?>
        <?php endforeach; ?>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
