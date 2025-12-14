<?php

namespace Twilio\Rest\Pricing;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Pricing\V2\VoiceList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class V2 extends Version
{
    protected $_voice;

    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
        $this->version = 'v2';
    }

    protected function getVoice(): VoiceList
    {
        if (!$this->_voice) {
            $this->_voice = new VoiceList($this);
        }
        return $this->_voice;
    }

    public function __get(string $name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        throw new TwilioException('Unknown resource ' . $name);
    }

    public function __call(string $name, array $arguments): InstanceContext
    {
        $property = $this->$name;
        if (method_exists($property, 'getContext')) {
            return call_user_func_array(array($property, 'getContext'), $arguments);
        }
        throw new TwilioException('Resource does not have a context');
    }

    public function __toString(): string
    {
        return '[Twilio.Pricing.V2]';
    }
}