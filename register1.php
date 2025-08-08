<?php
// Database connection details
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

// Register user
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);

    // Execute the statement
    if ($stmt->execute()) {
        $message = "Registration successful!"; // Set success message


    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
            background-image: url("sign4.jpg");
            background-size: cover;
            /* Ensure the background image covers the entire screen */
            background-position: center;
            /* Center the background image */
            font-family: Arial, sans-serif;
        }

        .register-container {
            width: 400px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.2);
            /* Light, semi-transparent white background */
            border: 1px solid #ddd;
            /* Light gray border */
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Soft shadow effect */
            color: #333;
            /* Dark text color */
            text-align: left;
            /* Center align text */
        }

        .register-container h1 {
            text-align: center;
            margin-bottom: 20px;
            /* Space below heading */
            color: #f5f5f5;
            /* Dark heading color */
        }

        .form-group {
            margin-bottom: 10px;
            /* Space between form elements */
        }

        .form-group label {
            display: block;
            /* Make labels block-level for better spacing */
            margin-bottom: 8px;
            font-weight: bold;
            color: lightcyan;
            /* Dark gray text color */
        }

        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            /* Light gray border */
            border-radius: 3px;
            box-sizing: border-box;
            /* Include padding in width calculation */
            font-size: 14px;
        }

        .but {
            width: 40%;
            padding: 10px;
            background-color: #1B1B1B;
            /* Blue background color */
            border: none;
            border-radius: 7px;
            color: #fff;
            /* White text color */
            font-size: 16px;
            cursor: pointer;
            margin: 0 auto;
            /* Center the button */
            display: block;
            /* Ensure the button behaves as a block element */
        }

        .but:hover {
            background-color: darkgrey;
            /* Darker blue on hover */
        }

        .login-link {
            margin-top: 10px;
            text-align: center;
            color: darkgray;
            /* Lighter text color */
        }

        .login-link a {
            color: #007bff;
            /* Link color */
            text-decoration: none;
            /* Remove underline */
        }

        .notification {
            display: none;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            z-index: 1;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <?php if (!empty($message)): ?>
        <div id="notification" class="notification">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    <div class="register-container">
        <h1>Register</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="username">Username : </label>
                <input type="text" id="username" name="username" required>
            </div><br>
            <div class="form-group">
                <label for="password">Password : </label>
                <input type="password" id="password" name="password" required>
            </div><br>
            <button type="submit" class="but">Register</button>
        </form>
        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
    <script>
        // JavaScript to display notification on successful registration
        document.addEventListener('DOMContentLoaded', function () {
            <?php if (!empty($message)): ?>
                var notification = document.getElementById('notification');
                notification.style.display = 'block';
                setTimeout(function () {
                    notification.style.display = 'none';
                    window.location.href = 'login.php';
                }, 2500); // Hide notification after 3 seconds
            <?php endif; ?>
        });
    </script>

</body>

</html>