<?php

namespace Twilio\Rest\Conversations\V1\Conversation\Message;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class DeliveryReceiptContext extends InstanceContext
{
    public function __construct(Version $version, $conversationSid, $messageSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['conversationSid' => $conversationSid, 'messageSid' => $messageSid, 'sid' => $sid,];
        $this->uri = '/Conversations/' . rawurlencode($conversationSid) . '/Messages/' . rawurlencode($messageSid) . '/Receipts/' . rawurlencode($sid) . '';
    }

    public function fetch(): DeliveryReceiptInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new DeliveryReceiptInstance($this->version, $payload, $this->solution['conversationSid'], $this->solution['messageSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Conversations.V1.DeliveryReceiptContext ' . implode(' ', $context) . ']';
    }
}