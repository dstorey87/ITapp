<?php
session_start();

// Your OAuth2 configuration
$clientID = '523dcd00cdfe40e8b11a455adf02fc65';
$clientSecret = 'ZbQiT940vfmxTun4riqZjGNw2imohWgiehn5cEaB';
$redirectUri = 'http://localhost:8080/callback';
$scope = 'publicData'; // Adjust scopes as needed

// Generate a random state string to prevent CSRF attacks
$state = bin2hex(random_bytes(16));
$_SESSION['oauth2_state'] = $state;

// Check if we have an authorization code
if (isset($_GET['code'])) {
    // Verify the state parameter
    if (isset($_GET['state']) && $_GET['state'] === $_SESSION['oauth2_state']) {
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
            die("Error retrieving access token: $error");
        }

        // Decode the response
        $responseData = json_decode($response, true);

        // Store the access token in the session
        if (isset($responseData['access_token'])) {
            $_SESSION['access_token'] = $responseData['access_token'];
            header('Location: index.php'); // Redirect to index.php
            exit();
        } else {
            die("Error retrieving access token: " . print_r($responseData, true));
        }
    } else {
        die("Invalid state parameter.");
    }
} else {
    // Redirect user to EVE Online authorization page
    $authUrl = "https://login.eveonline.com/v2/oauth/authorize?response_type=code&client_id={$clientID}&redirect_uri=" . urlencode($redirectUri) . "&scope=publicData&state=" . urlencode($state);
    header("Location: $authUrl");
    exit();
}
?>
