<?php
require 'vendor/autoload.php';
$apiKey = getenv('SENDGRID_API_KEY');
$sg = new SendGrid($apiKey);
$query_params = json_decode('{"limit": 1}');
try {
    $response = $sg->client->access_settings()->activity()->get(null, $query_params);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$request_body = json_decode('{
  "ips": [
    {
      "ip": "192.168.1.1"
    },
    {
      "ip": "192.*.*.*"
    },
    {
      "ip": "192.168.1.3/32"
    }
  ]
}');
try {
    $response = $sg->client->access_settings()->whitelist()->post($request_body);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
try {
    $response = $sg->client->access_settings()->whitelist()->get();
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$request_body = json_decode('{
  "ids": [
    1,
    2,
    3
  ]
}');
try {
    $response = $sg->client->access_settings()->whitelist()->delete($request_body);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$rule_id = "test_url_param";
try {
    $response = $sg->client->access_settings()->whitelist()->_($rule_id)->get();
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$rule_id = "test_url_param";
try {
    $response = $sg->client->access_settings()->whitelist()->_($rule_id)->delete();
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
