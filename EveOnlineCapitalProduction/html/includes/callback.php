<?php
session_start();
include_once __DIR__ . '/db.php';
include_once __DIR__ . '/logging.php';  // Log callback events

log_message("Callback script accessed.");

if (!isset($_GET['code'])) {
    log_message("Error: No authorization code returned.");
    die("Error: No authorization code returned.");
}

// OAuth2 configuration
$clientID = '523dcd00cdfe40e8b11a455adf02fc65';
$clientSecret = 'ZbQiT940vfmxTun4riqZjGNw2imohWgiehn5cEaB';
$redirectUri = 'http://localhost:8080/includes/callback.php';

// Exchange the authorization code for an access token
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
    'code' => $_GET['code'],
    'redirect_uri' => $redirectUri,
]));
$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    log_message("Error retrieving access token: $error");
    die("Error retrieving access token: $error");
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
?>