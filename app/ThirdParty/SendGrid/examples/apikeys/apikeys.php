<?php
require 'vendor/autoload.php';
$apiKey = getenv('SENDGRID_API_KEY');
$sg = new SendGrid($apiKey);
$request_body = json_decode('{
  "name": "My API Key",
  "sample": "data",
  "scopes": [
    "mail.send",
    "alerts.create",
    "alerts.read"
  ]
}');
try {
    $response = $sg->client->api_keys()->post($request_body);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$query_params = json_decode('{"limit": 1}');
try {
    $response = $sg->client->api_keys()->get(null, $query_params);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$request_body = json_decode('{
  "name": "A New Hope",
  "scopes": [
    "user.profile.read",
    "user.profile.update"
  ]
}');
$api_key_id = "test_url_param";
try {
    $response = $sg->client->api_keys()->_($api_key_id)->put($request_body);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$request_body = json_decode('{
  "name": "A New Hope"
}');
$api_key_id = "test_url_param";
try {
    $response = $sg->client->api_keys()->_($api_key_id)->patch($request_body);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$api_key_id = "test_url_param";
try {
    $response = $sg->client->api_keys()->_($api_key_id)->get();
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$api_key_id = "test_url_param";
try {
    $response = $sg->client->api_keys()->_($api_key_id)->delete();
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
