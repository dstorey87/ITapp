<?php
// Start the session
session_start();

// Include database connection
include('db.php');

// Check for OAuth2 login
if (!isset($_SESSION['access_token'])) {
    header('Location: oauth.php');
    exit();
}

// Fetch user data and display
$userData = getUserData($_SESSION['access_token']);

// Fetch data from the test_table
$result = $conn->query("SELECT * FROM test_table");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVE Online Capital Ship Production</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to the CSS file -->
</head>
<body>
    <!-- Navigation Bar -->
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="contact.php">Contact Us</a></li>
        </ul>
    </nav>
    
    <!-- Logo -->
    <div class="logo">
        <img src="image.png" alt="Imperium Technologies Logo">
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <h1>Welcome, <?php echo htmlspecialchars($userData['name']); ?></h1>
        <h2>Recent Kills</h2>
        <iframe src="https://zkillboard.com/character/146531499/widget/"></iframe>
    </div>
    
    <!-- Test Table Data -->
    <div class="table-data">
        <h2>Test Table Data</h2>
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "ID: " . htmlspecialchars($row["id"]) . " - Name: " . htmlspecialchars($row["name"]) . "<br>";
            }
        } else {
            echo "No results found in the test table.";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>
</html>
