<?php
ob_start();  // Start output buffering

// Start the session
session_start();

// Include database connection
include('db.php');

// Function to fetch user data
function getUserData($accessToken) {
    $url = "https://esi.evetech.net/verify/";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        die("Error retrieving user data: $error");
    }

    return json_decode($response, true);
}

// Check for OAuth2 login
if (!isset($_SESSION['access_token'])) {
    header('Location: oauth.php');
    exit();
}

// Fetch user data and display
$userData = getUserData($_SESSION['access_token']);

// Fetch data from the test_table
$result = $conn->query("SELECT * FROM test_table");

// End output buffering and send output
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVE Online Capital Ship Production</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($userData['name']); ?></h1>
    
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
</body>
</html>
