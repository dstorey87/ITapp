<?php
// Start session
session_start();

// Include database connection
include('includes/db.php');  // Path updated to 'includes/'

// Log when index page is accessed
log_message("Index page accessed.");

// Fetch cached corporation details
$corpData = null;
$cacheFile = 'cache/corp_cache.json';  // Cache file moved to 'cache/' folder

// Check if the cache file exists and is recent (within 24 hours)
if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < 86400)) {
    $corpData = json_decode(file_get_contents($cacheFile), true);
    log_message("Corporation details loaded from cache.");
} else {
    // Fetch corporation data from EVE Swagger API and cache it
    $corporationID = '146531499';  // Imperium Technologies ID
    $url = "https://esi.evetech.net/latest/corporations/{$corporationID}/?datasource=tranquility";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        log_message("cURL error: " . curl_error($ch));
        die("Failed to retrieve corporation data.");
    }
    
    curl_close($ch);
    
    if ($response) {
        $corpData = json_decode($response, true);
        if ($corpData) {
            file_put_contents($cacheFile, json_encode($corpData));  // Cache the response
            log_message("Corporation details successfully fetched and cached.");
        } else {
            log_message("Error decoding corporation data.");
            die("Failed to decode corporation data.");
        }
    } else {
        log_message("Failed to retrieve corporation data.");
        die("Failed to retrieve corporation data.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVE Online Corporation Details</title>
    <link rel="stylesheet" href="assets/styles/styles.css"> <!-- Path updated to new assets directory -->
</head>
<body>
    <header>
        <h1>EVE Online Capital Ship Production</h1>
    </header>

    <main>
        <div class="center-content">
            <h2>Corporation Details</h2>
            <?php if ($corpData): ?>
                <div class="corp-details">
                    <!-- Check if corporation_id exists before trying to use it -->
                    <img src="https://image.eveonline.com/Corporation/<?php echo htmlspecialchars($corpData['corporation_id'] ?? ''); ?>_128.png" alt="Corp Logo" class="corp-logo">
                    <p><strong>Corporation Name:</strong> <?php echo htmlspecialchars($corpData['name'] ?? 'Unknown'); ?></p>
                    <p><strong>CEO:</strong> <?php echo htmlspecialchars($corpData['ceo_name'] ?? 'Unknown'); ?></p>
                    <p><strong>Founded:</strong> <?php echo isset($corpData['date_founded']) ? date('F j, Y', strtotime($corpData['date_founded'])) : 'Unknown'; ?></p>
                    <p><strong>Member Count:</strong> <?php echo htmlspecialchars($corpData['member_count'] ?? 'Unknown'); ?></p>
                </div>
            <?php else: ?>
                <p>Corporation data is unavailable at the moment. Please check back later.</p>
            <?php endif; ?>

            <a href="includes/oauth.php" class="btn">Sign in with EVE Online</a> <!-- Path updated to includes directory -->
        </div>
    </main>

    <footer>
        <p>&copy; 2024 EVE Online Capital Ship Production</p>
    </footer>

</body>
</html>
