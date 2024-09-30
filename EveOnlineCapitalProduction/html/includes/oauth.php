<?php
// EveOnlineCapitalProduction/html/includes/oauth.php

session_start();
include_once __DIR__ . '/logging.php';  // Ensure the correct path to logging.php

if (!function_exists('log_message')) {
    die("Error: log_message function is not defined. Please check the logging.php file.");
}

log_message("OAuth script started");

// Your OAuth2 configuration
$clientID = '523dcd00cdfe40e8b11a455adf02fc65';
$clientSecret = 'ZbQiT940vfmxTun4riqZjGNw2imohWgiehn5cEaB';
$redirectUri = 'http://localhost:8080/includes/callback.php';
$scope = 'publicData';  // Adjust scopes as needed

// Generate a random state string to prevent CSRF attacks
try {
    $state = bin2hex(random_bytes(16));
    $_SESSION['oauth2_state'] = $state;
} catch (Exception $e) {
    log_message("Error generating state: " . $e->getMessage());
    die("Error generating state: " . $e->getMessage());
}

// Check if we have an authorization code
if (isset($_GET['code'])) {
    log_message("Authorization code received. Processing...");

    // Verify the state parameter
    if (isset($_GET['state']) && $_GET['state'] === $_SESSION['oauth2_state']) {
        log_message("State verified. Exchanging authorization code for access token...");

        // Exchange authorization code for access token
        $code = $_GET['code'];
        $tokenUrl = 'https://login.eveonline.com/v2/oauth/token';

        $ch = curl_init($tokenUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic ' . base64_encode("$clientID:$clientSecret")
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirectUri,
        ]));

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            log_message("Curl error: " . $error);
            die("Curl error: " . $error);
        }

        $responseData = json_decode($response, true);
        if (isset($responseData['access_token'])) {
            $_SESSION['access_token'] = $responseData['access_token'];
            log_message("Access token received and stored. Redirecting to index.php.");
            header('Location: ../index.php');
            exit();
        } else {
            log_message("Error: Access token not received. Response: " . print_r($responseData, true));
            die("Error: Access token not received.");
        }
    } else {
        log_message("State verification failed.");
        die("State verification failed.");
    }
} else {
    log_message("No authorization code received. Redirecting to OAuth provider...");

    // Redirect to the OAuth provider's authorization endpoint
    $authUrl = 'https://login.eveonline.com/v2/oauth/authorize?' . http_build_query([
        'response_type' => 'code',
        'client_id' => $clientID,
        'redirect_uri' => $redirectUri,
        'scope' => $scope,
        'state' => $state,
    ]);

    header('Location: ' . $authUrl);
    exit();
}
?>