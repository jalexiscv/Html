<?php

use SendGrid\Mail\Mail;

require 'vendor/autoload.php';
$email = new Mail();
$email->setFrom('dx@sendgrid.com', "à è ì ò ù");
$email->setSubject("à è ì ò ù");
$email->addTo("elmer.thomas@sendgrid.com", "Y Y");
$email->addContent("text/html", "à è ì ò ù");
$sendgrid = new SendGrid(getenv('SENDGRID_API_KEY'));
try {
    $response = $sendgrid->send($email);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ' . $e->getMessage() . "\n";
}
