<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Search Bar Example</title>
<style>
    /* Minimal CSS for the search bar */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        background-image: url("pl.jpg");
        background-size: cover;
        background-repeat: no-repeat;
        backdrop-filter: blur(10px);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        width: 100%;
        max-width: 800px; /* Adjust max-width as needed */
        padding: 20px;
        box-sizing: border-box;
    }
    
    .top-layout {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 20px; /* Space between search bar and player details */
    }

    .search-container {
        display: flex;
        width: 100%;
        max-width: 500px; /* Adjust max-width as needed */
        border: 1px solid #ccc;
        border-radius: 20px;
        overflow: hidden;
        position: relative;
    }
    
    .search-input {
        width: 100%;
        padding: 10px;
        border: none;
        font-size: 16px;
    }
    
    .search-button {
        background-color: rgba(57, 53, 53, 0.5);
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
    }
    
    .search-button:hover {
        background-color:green;
    }
    
    .player-details {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        max-width: 600px; /* Adjust max-width as needed */
        margin: 0 auto; /* Center align player details */
        padding: 20px;
        background-color: rgba(0, 5, 6, 0.3);
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        color: aliceblue;
    }
    
    .player-details h1 {
        color: #007bff;
        margin-bottom: 10px;
    }
    
    .player-details p {
        margin: 5px 0;
    }
    
    .player-image {
        flex: 1;
        max-width: 500px; /* Adjust max-width as needed */
        margin-right: 20px;
    }
    
    .player-image img {
        width: 100%;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }
    
</style>
</head>
<body>
    <div class="container">
        <div class="top-layout">
            <div class="search-container">
                <input id="playerName" type="text" placeholder="Enter the player name" class="search-input">
                <button type="button" class="search-button" onclick="searchPlayer()">Search</button>
            </div>
        </div>

        <!-- Player details will be displayed below the search bar -->
        <div id="playerDetails">
            <!-- PHP code to display player details goes here -->
            <?php
            // Check if pname parameter is set in the URL
            if (isset($_GET['pname'])) {
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
                
                // Retrieve and sanitize the player name from the URL parameter
                $entered_player_name = htmlspecialchars($_GET['pname']);
                
                // Prepare SQL statement to fetch player details
                $stmt = $conn->prepare("SELECT name, country, age, role, batting_style, bowling_style, matches, runs, average, strike_rate, centuries, fifties, image FROM cricket_players WHERE name = ?");
                $stmt->bind_param("s", $entered_player_name);
                $stmt->execute();
                $result = $stmt->get_result();
                
                // Check if player exists
                if ($result->num_rows > 0) {
                    // Player details found, display them
                    $player = $result->fetch_assoc();
                    echo '<div class="player-details">';
                    echo '<div class="player-image">';
                    echo '<img src="' . htmlspecialchars($player['image']) . '" alt="Player Image" height="400" width="500"">';
                    echo '</div>';
                    echo '<div class="player-info">';
                    echo '<h1>Player Details</h1>';
                    echo '<p><strong>Name:</strong> ' . htmlspecialchars($player['name']) . '</p>';
                    echo '<p><strong>Country:</strong> ' . htmlspecialchars($player['country']) . '</p>';
                    echo '<p><strong>Age:</strong> ' . $player['age'] . '</p>';
                    echo '<p><strong>Role:</strong> ' . htmlspecialchars($player['role']) . '</p>';
                    echo '<p><strong>Batting Style:</strong> ' . htmlspecialchars($player['batting_style']) . '</p>';
                    echo '<p><strong>Bowling Style:</strong> ' . htmlspecialchars($player['bowling_style']) . '</p>';
                    echo '<p><strong>Matches:</strong> ' . $player['matches'] . '</p>';
                    echo '<p><strong>Runs:</strong> ' . $player['runs'] . '</p>';
                    echo '<p><strong>Average:</strong> ' . $player['average'] . '</p>';
                    echo '<p><strong>Strike Rate:</strong> ' . $player['strike_rate'] . '</p>';
                    echo '<p><strong>Centuries:</strong> ' . $player['centuries'] . '</p>';
                    echo '<p><strong>Fifties:</strong> ' . $player['fifties'] . '</p>';
                    echo '</div>';
                    echo '</div>';
                } else {
                    // Player not found
                    echo '<div class="player-details">';
                    echo '<p>Player not found.</p>';
                    echo '</div>';
                }
                
                // Close statement and connection
                $stmt->close();
                $conn->close();
            } 
            ?>
        </div>
    </div>
    
    <script>
        function searchPlayer() {
            var playerName = document.getElementById("playerName").value;
            if (playerName.trim() !== "") {
                // Redirect to player.php with player name as parameter
                var url = 'player.php?pname=' + encodeURIComponent(playerName);
                // Redirect to the constructed URL
                window.location.href = url;
            } else {
                alert("Please enter a player name.");
            }
        }
    </script>
</body>
</html>
