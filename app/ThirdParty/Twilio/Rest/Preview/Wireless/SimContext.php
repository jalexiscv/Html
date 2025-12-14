<?php

namespace Twilio\Rest\Preview\Wireless;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Preview\Wireless\Sim\UsageContext;
use Twilio\Rest\Preview\Wireless\Sim\UsageList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class SimContext extends InstanceContext
{
    protected $_usage;

    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Sims/' . rawurlencode($sid) . '';
    }

    public function fetch(): SimInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new SimInstance($this->version, $payload, $this->solution['sid']);
    }

    public function update(array $options = []): SimInstance
    {
        $options = new Values($options);
        $data = Values::of(['UniqueName' => $options['uniqueName'], 'CallbackMethod' => $options['callbackMethod'], 'CallbackUrl' => $options['callbackUrl'], 'FriendlyName' => $options['friendlyName'], 'RatePlan' => $options['ratePlan'], 'Status' => $options['status'], 'CommandsCallbackMethod' => $options['commandsCallbackMethod'], 'CommandsCallbackUrl' => $options['commandsCallbackUrl'], 'SmsFallbackMethod' => $options['smsFallbackMethod'], 'SmsFallbackUrl' => $options['smsFallbackUrl'], 'SmsMethod' => $options['smsMethod'], 'SmsUrl' => $options['smsUrl'], 'VoiceFallbackMethod' => $options['voiceFallbackMethod'], 'VoiceFallbackUrl' => $options['voiceFallbackUrl'], 'VoiceMethod' => $options['voiceMethod'], 'VoiceUrl' => $options['voiceUrl'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new SimInstance($this->version, $payload, $this->solution['sid']);
    }

    protected function getUsage(): UsageList
    {
        if (!$this->_usage) {
            $this->_usage = new UsageList($this->version, $this->solution['sid']);
        }
        return $this->_usage;
    }

    public function __get(string $name): ListResource
    {
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown subresource ' . $name);
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
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Preview.Wireless.SimContext ' . implode(' ', $context) . ']';
    }
}