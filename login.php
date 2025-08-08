<?php
// Start session
session_start();

// Database connection details
$servername = "localhost";  // Replace with your MySQL server host
$username = "hari";  // Replace with your MySQL username
$password = "hari@1234";  // Replace with your MySQL password
$dbname = "cricket";  // Replace with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_username = $_POST['username'];
    $entered_password = $_POST['password'];

    // SQL query to retrieve hashed password for the given username
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $entered_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User exists, verify password
        $row = $result->fetch_assoc();
        $stored_hashed_password = $row['password'];

        // Verify the entered password against the stored hashed password
        if (password_verify($entered_password, $stored_hashed_password)) {
            // Passwords match, set session variables and redirect
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: web.html"); // Redirect to home page after successful login
            exit();
        } else {
            // Passwords do not match
            $error_message = "Invalid username or password.";
        }
    } else {
        // Passwords do not match
        $error_message = "Invalid username or password.";
    }
    

    // Close statement
    $stmt->close();
}


// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            background-image: url("player.jpg");
            background-size: cover;
            
        }

        .register-container {
            width: 400px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.4);
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .register-container h1 {
            margin-bottom: 20px;
            color: #333;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: calc(100% - 12px);
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 3px;
            transition: border-color 0.3s ease-in-out;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="password"]:focus {
            outline: none;
            border-color: #007bff;
        }

        .form-group input[type="submit"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: rgba(65, 42, 10, 1);
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .form-group input[type="submit"]:hover {
            background-color: brown;
        }
    </style>
</head>
<body>
<div class="register-container">
    <h1>Sign In</h1>
    <!-- Display error message if exists -->
    <?php if (!empty($error_message)): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="username"><b>Username :</b></label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password"><b>Password:</b></label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <input type="submit" value="Sign In">
        </div>
    </form>
</div>
</body>
</html>