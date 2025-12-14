<?php

use SendGrid\Client;
use SendGrid\Mail\Mail;
use SendGrid\Response;

class SendGrid
{
    const VERSION = '7.3.0';
    protected $namespace = 'SendGrid';
    public $client;
    public $version = self::VERSION;

    public function __construct($apiKey, $options = array())
    {
        $headers = array('Authorization: Bearer ' . $apiKey, 'User-Agent: sendgrid/' . $this->version . ';php', 'Accept: application/json');
        $host = isset($options['host']) ? $options['host'] : 'https://api.sendgrid.com';
        if (!empty($options['impersonateSubuser'])) {
            $headers[] = 'On-Behalf-Of: ' . $options['impersonateSubuser'];
        }
        $curlOptions = isset($options['curl']) ? $options['curl'] : null;
        $this->client = new Client($host, $headers, '/v3', null, $curlOptions);
    }

    public function send(Mail $email)
    {
        return $this->client->mail()->send()->post($email);
    }
}
