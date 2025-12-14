<?php

namespace App\Libraries;

use SendGrid;
use SendGrid\Mail\Attachment;
use SendGrid\Mail\Mail;

require_once(APPPATH . 'ThirdParty/SendGrid/autoload.php');

class Sms
{
    private $account;
    private $apikey;
    private $token;
    private $apiurl;

// URL del endpoint al que deseas enviar la solicitud POST
    private $url;

    private $data;

    public function __construct($items = array())
    {
        $this->account = "10026255";
        $this->apikey = "CCJx7MeEcgFtzGQosdfUqFOtwL6IlI";
        $this->token = "d43ec5dee6d2a1f9c766163c0a714997";
        $this->apiurl = "https://api103.hablame.co/api";
        $this->url = $this->apiurl . "/sms/v3/send/marketing";
    }

    public function send($number, $message)
    {
        $this->data = array(
            "toNumber" => "{$number}",
            "sms" => "{$message}",
            "flash" => "0",
            "sc" => "890202",
            "request_dlvr_rcpt" => "0"
        );
        $jsonData = json_encode($this->data);
        $options = array(
            CURLOPT_URL => $this->url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Account: " . $this->account,
                "ApiKey: " . $this->apikey,
                "Content-Type: application/json",
                "Token: " . $this->token
            )
        );
        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error = curl_error($curl);
        } else {
            $responseData = json_decode($response, true);
            //print_r($responseData);
        }
        curl_close($curl);
        return ($responseData);
    }

}

?>