<?php
include 'includes/db.php';
include 'includes/logging.php';  // For logging errors

log_message("Worker script started");

$corporationID = 146531499;  // Imperium Technologies ID
log_message("Starting API request for corporation ID: $corporationID");

// Bypass cache and forcefully pull new data from the ESI API
$url = "https://esi.evetech.net/latest/corporations/$corporationID/";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

if (curl_errno($ch)) {
    log_message("Curl error: " . curl_error($ch));
    die("Curl error: " . curl_error($ch));
} else {
    log_message("API request successful. Response: " . $response);
}
curl_close($ch);

$corpData = json_decode($response, true);
log_message("Decoded JSON response: " . print_r($corpData, true));

if (isset($corpData['corporation_id'])) {
    $name = $corpData['name'] ?? 'Unknown';
    $ticker = $corpData['ticker'] ?? 'Unknown';
    $date_founded = $corpData['date_founded'] ?? '0000-00-00';

    // Insert corporation data into database
    $query = "REPLACE INTO corp_cache (corporation_id, name, ticker, date_founded, timestamp)
              VALUES ('$corporationID', '$name', '$ticker', '$date_founded', NOW())";
    log_message("SQL Query: " . $query);

    if (mysqli_query($conn, $query)) {
        log_message("Corporation details successfully cached in the database.");
        echo "Corporation details successfully cached in the database.\n";
    } else {
        log_message("Database error: " . mysqli_error($conn));
        die("Database error: " . mysqli_error($conn));
    }
} else {
    log_message("Error: Corporation data is missing or invalid.");
    die("Error: Corporation data is missing or invalid.");
}
?>
