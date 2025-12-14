<?php
require 'vendor/autoload.php';
$apiKey = getenv('SENDGRID_API_KEY');
$sg = new SendGrid($apiKey);
$request_body = json_decode('{
  "name": "example_name"
}');
try {
    $response = $sg->client->templates()->post($request_body);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
try {
    $response = $sg->client->templates()->get();
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$request_body = json_decode('{
  "name": "new_example_name"
}');
$template_id = "test_url_param";
try {
    $response = $sg->client->templates()->_($template_id)->patch($request_body);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$template_id = "test_url_param";
try {
    $response = $sg->client->templates()->_($template_id)->get();
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$template_id = "test_url_param";
try {
    $response = $sg->client->templates()->_($template_id)->delete();
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$request_body = json_decode('{
  "active": 1,
  "html_content": "<%body%>",
  "name": "example_version_name",
  "plain_content": "<%body%>",
  "subject": "<%subject%>",
  "template_id": "ddb96bbc-9b92-425e-8979-99464621b543"
}');
$template_id = "test_url_param";
try {
    $response = $sg->client->templates()->_($template_id)->versions()->post($request_body);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$request_body = json_decode('{
  "active": 1,
  "html_content": "<%body%>",
  "name": "updated_example_name",
  "plain_content": "<%body%>",
  "subject": "<%subject%>"
}');
$template_id = "test_url_param";
$version_id = "test_url_param";
try {
    $response = $sg->client->templates()->_($template_id)->versions()->_($version_id)->patch($request_body);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$template_id = "test_url_param";
$version_id = "test_url_param";
try {
    $response = $sg->client->templates()->_($template_id)->versions()->_($version_id)->get();
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$template_id = "test_url_param";
$version_id = "test_url_param";
try {
    $response = $sg->client->templates()->_($template_id)->versions()->_($version_id)->delete();
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
$template_id = "test_url_param";
$version_id = "test_url_param";
try {
    $response = $sg->client->templates()->_($template_id)->versions()->_($version_id)->activate()->post();
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
