<?php

namespace App\Libraries;

use SendGrid;
use SendGrid\Mail\Attachment;
use SendGrid\Mail\Mail;

require_once(APPPATH . 'ThirdParty/SendGrid/autoload.php');

class Message
{

    //private $apikey = "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";
    //private $apikey = "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";
    private $apikey = "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";

    private $email = null;

    public function __construct($items = array())
    {
        $this->email = new Mail();
    }

    public function setFrom($email, $name)
    {
        $this->email->setFrom($email, $name);
    }

    public function setSubject($subject)
    {
        $this->email->setSubject($subject);
    }

    public function addTo($email, $name)
    {
        $this->email->addTo($email, $name);
    }

    public function addContentText($content)
    {
        $this->email->addContent("text/plain", $content);
    }

    public function addContentHTML($content)
    {
        $this->email->addContent("text/html", $content);
    }


    public function addAttachment($attachment, $type = null, $filename = null, $disposition = null, $content_id = null)
    {
        $this->email->addAttachment($attachment, $type, $filename, $disposition, $content_id);
    }


    public function send($type)
    {
        if ($type == "email") {
            $sendgrid = new SendGrid($this->apikey);
            try {
                $response = $sendgrid->send($this->email);
                $msg = "Class/Message/StatusCode: " . $response->statusCode() . "";
                //print_r($response->headers());
                //print $response->body() . "\n";
                log_message('debug', $msg);
            } catch (Exception $e) {
                $msg = 'Class/Message/CaughtException: ' . $e->getMessage() . "";
                log_message('error', $msg);
            }
        }
    }

}

?>