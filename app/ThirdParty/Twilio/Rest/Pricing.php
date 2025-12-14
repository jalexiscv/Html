<?php

namespace Twilio\Rest;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Rest\Pricing\V1;
use Twilio\Rest\Pricing\V1\MessagingList;
use Twilio\Rest\Pricing\V1\PhoneNumberList;
use Twilio\Rest\Pricing\V2;
use Twilio\Rest\Pricing\V2\VoiceList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class Pricing extends Domain
{
    protected $_v1;
    protected $_v2;

    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->baseUrl = 'https://pricing.twilio.com';
    }

    protected function getV1(): V1
    {
        if (!$this->_v1) {
            $this->_v1 = new V1($this);
        }
        return $this->_v1;
    }

    protected function getV2(): V2
    {
        if (!$this->_v2) {
            $this->_v2 = new V2($this);
        }
        return $this->_v2;
    }

    public function __get(string $name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        throw new TwilioException('Unknown version ' . $name);
    }

    public function __call(string $name, array $arguments)
    {
        $method = 'context' . ucfirst($name);
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $arguments);
        }
        throw new TwilioException('Unknown context ' . $name);
    }

    protected function getMessaging(): MessagingList
    {
        return $this->v1->messaging;
    }

    protected function getPhoneNumbers(): PhoneNumberList
    {
        return $this->v1->phoneNumbers;
    }

    protected function getVoice(): VoiceList
    {
        return $this->v2->voice;
    }

    public function __toString(): string
    {
        return '[Twilio.Pricing]';
    }
}