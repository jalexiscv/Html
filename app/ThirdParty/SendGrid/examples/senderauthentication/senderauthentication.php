<?php
require 'vendor/autoload.php';
$apiKey = getenv('SENDGRID_API_KEY');
$sg = new SendGrid($apiKey);
$request_body = json_decode('{
  "automatic_security": false,
  "custom_spf": true,
  "default": true,
  "domain": "example.com",
  "ips": [
    "192.168.1.1",
    "192.168.1.2"
  ],
  "subdomain": "news",
  "username": "john@example.com"
}');
try {
    $response = $sg->client->whitelabel()->domains()->post($request_body);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$query_params = json_decode('{"username": "test_string", "domain": "test_string", "exclude_subusers": "true", "limit": 1, "offset": 1}');
try {
    $response = $sg->client->whitelabel()->domains()->get(null, $query_params);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
try {
    $response = $sg->client->whitelabel()->domains()->default()->get();
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
try {
    $response = $sg->client->whitelabel()->domains()->subuser()->get();
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
try {
    $response = $sg->client->whitelabel()->domains()->subuser()->delete();
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$request_body = json_decode('{
  "custom_spf": true,
  "default": false
}');
$domain_id = "test_url_param";
try {
    $response = $sg->client->whitelabel()->domains()->_($domain_id)->patch($request_body);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$domain_id = "test_url_param";
try {
    $response = $sg->client->whitelabel()->domains()->_($domain_id)->get();
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$domain_id = "test_url_param";
try {
    $response = $sg->client->whitelabel()->domains()->_($domain_id)->delete();
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$request_body = json_decode('{
  "username": "jane@example.com"
}');
$domain_id = "test_url_param";
try {
    $response = $sg->client->whitelabel()->domains()->_($domain_id)->subuser()->post($request_body);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$request_body = json_decode('{
  "ip": "192.168.0.1"
}');
$id = "test_url_param";
try {
    $response = $sg->client->whitelabel()->domains()->_($id)->ips()->post($request_body);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$id = "test_url_param";
$ip = "test_url_param";
try {
    $response = $sg->client->whitelabel()->domains()->_($id)->ips()->_($ip)->delete();
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$id = "test_url_param";
try {
    $response = $sg->client->whitelabel()->domains()->_($id)->validate()->post();
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$request_body = json_decode('{
  "domain": "example.com",
  "ip": "192.168.1.1",
  "subdomain": "email"
}');
try {
    $response = $sg->client->whitelabel()->ips()->post($request_body);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$query_params = json_decode('{"ip": "test_string", "limit": 1, "offset": 1}');
try {
    $response = $sg->client->whitelabel()->ips()->get(null, $query_params);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$id = "test_url_param";
try {
    $response = $sg->client->whitelabel()->ips()->_($id)->get();
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$id = "test_url_param";
try {
    $response = $sg->client->whitelabel()->ips()->_($id)->delete();
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$id = "test_url_param";
try {
    $response = $sg->client->whitelabel()->ips()->_($id)->validate()->post();
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$request_body = json_decode('{
  "default": true,
  "domain": "example.com",
  "subdomain": "mail"
}');
$query_params = json_decode('{"limit": 1, "offset": 1}');
try {
    $response = $sg->client->whitelabel()->links()->post($request_body, $query_params);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$query_params = json_decode('{"limit": 1}');
try {
    $response = $sg->client->whitelabel()->links()->get(null, $query_params);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$query_params = json_decode('{"domain": "test_string"}');
try {
    $response = $sg->client->whitelabel()->links()->default()->get(null, $query_params);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$query_params = json_decode('{"username": "test_string"}');
try {
    $response = $sg->client->whitelabel()->links()->subuser()->get(null, $query_params);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$query_params = json_decode('{"username": "test_string"}');
try {
    $response = $sg->client->whitelabel()->links()->subuser()->delete(null, $query_params);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$request_body = json_decode('{
  "default": true
}');
$id = "test_url_param";
try {
    $response = $sg->client->whitelabel()->links()->_($id)->patch($request_body);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$id = "test_url_param";
try {
    $response = $sg->client->whitelabel()->links()->_($id)->get();
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$id = "test_url_param";
try {
    $response = $sg->client->whitelabel()->links()->_($id)->delete();
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$id = "test_url_param";
try {
    $response = $sg->client->whitelabel()->links()->_($id)->validate()->post();
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$request_body = json_decode('{
  "username": "jane@example.com"
}');
$link_id = "test_url_param";
try {
    $response = $sg->client->whitelabel()->links()->_($link_id)->subuser()->post($request_body);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
