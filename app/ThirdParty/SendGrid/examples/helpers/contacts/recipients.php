<?php
namespace SendGrid;

use SendGrid;

require __DIR__ . '<PATH_TO>/vendor/autoload.php';
function buildRecipientForm($url = 'http://www.example.com/recipientFormSubmit')
{
    $form = (string)new \SendGrid\Contacts\RecipientForm($url);
    echo $form . PHP_EOL;
}

function recipientFormSubmit()
{
    $apiKey = getenv('SENDGRID_API_KEY');
    $sg = new SendGrid($apiKey);
    $post_body = array('first-name' => 'Test', 'last-name' => 'Tester', 'email' => 'test@test.com');
    $firstName = $post_body['first-name'];
    $lastName = $post_body['last-name'];
    $email = $post_body['email'];
    $recipient = new \SendGrid\Contacts\Recipient($firstName, $lastName, $email);
    $request_body = json_decode('[
        {
            "email": "' . $recipient->getEmail() . '",
            "first_name": "' . $recipient->getFirstName() . '",
            "last_name": "' . $recipient->getLastName() . '"
        }
    ]');
    try {
        $response = $sg->client->contactdb()->recipients()->post($request_body);
        print $response->statusCode() . "\n";
        print_r($response->headers());
        print $response->body() . "\n";
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
}

buildRecipientForm();
recipientFormSubmit(); ?>


