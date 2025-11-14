<?php
session_start();

$credentials = json_decode(file_get_contents('secret.json'), true)['web'];
$clientId = $credentials['client_id'];
$clientSecret = $credentials['client_secret'];
$redirectUri = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

echo "DEBUG: Credentials loaded. Redirect URI is: " . htmlspecialchars($redirectUri) . "<br>";

$blogUrl = 'https://jalexiscv.blogspot.com/';

// Step 1: Redirect to Google's OAuth 2.0 server
if (!isset($_GET['code'])) {
    $authUrl = 'https://accounts.google.com/o/oauth2/auth?' . http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'scope' => 'https://www.googleapis.com/auth/blogger',
            'response_type' => 'code',
            'access_type' => 'offline',
            'prompt' => 'consent'
        ]);
    echo "<a href='$authUrl'>Authorize and Post to Blogger</a>";
} // Step 2: Receive the authorization code and exchange it for an access token
else {
    $code = $_GET['code'];
    $tokenUrl = 'https://oauth2.googleapis.com/token';
    $postData = [
        'code' => $code,
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'redirect_uri' => $redirectUri,
        'grant_type' => 'authorization_code'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $tokenUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $tokenData = json_decode($response, true);

    if (isset($tokenData['access_token'])) {
        $_SESSION['access_token'] = $tokenData['access_token'];

        // Step 3: Get the blog ID
        $blogInfoUrl = 'https://www.googleapis.com/blogger/v3/blogs/byurl?url=' . urlencode($blogUrl);
        $headers = [
            'Authorization: Bearer ' . $_SESSION['access_token']
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $blogInfoUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $blogInfo = json_decode($response, true);
        if (isset($blogInfo['id'])) {
            $blogId = $blogInfo['id'];

            // Step 4: Use the access token to create a new post
            $postUrl = "https://www.googleapis.com/blogger/v3/blogs/{$blogId}/posts/";
            $postData = json_encode([
                'kind' => 'blogger#post',
                'title' => 'A New Post (from scratch)',
                'content' => 'This post was created without any third-party libraries!'
            ]);

            $headers = [
                'Authorization: Bearer ' . $_SESSION['access_token'],
                'Content-Type: application/json'
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $postUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            $postResponse = json_decode($response, true);

            if (isset($postResponse['url'])) {
                echo "Post created successfully! <a href='{$postResponse['url']}'>View Post</a>";
            } else {
                echo "Error creating post: <pre>" . print_r($postResponse, true) . "</pre>";
            }
        } else {
            echo "Error fetching blog ID. Response: <pre>" . htmlspecialchars(print_r($blogInfo, true)) . "</pre>";
        }
    } else {
        echo "Error fetching access token. Response: <pre>" . htmlspecialchars(print_r($tokenData, true)) . "</pre>";
    }
}
?>
