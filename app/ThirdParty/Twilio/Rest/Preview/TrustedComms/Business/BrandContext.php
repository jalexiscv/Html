<?php

namespace Twilio\Rest\Preview\TrustedComms\Business;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Preview\TrustedComms\Business\Brand\BrandedChannelContext;
use Twilio\Rest\Preview\TrustedComms\Business\Brand\BrandedChannelList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class BrandContext extends InstanceContext
{
    protected $_brandedChannels;

    public function __construct(Version $version, $businessSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['businessSid' => $businessSid, 'sid' => $sid,];
        $this->uri = '/Businesses/' . rawurlencode($businessSid) . '/Brands/' . rawurlencode($sid) . '';
    }

    public function fetch(): BrandInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new BrandInstance($this->version, $payload, $this->solution['businessSid'], $this->solution['sid']);
    }

    protected function getBrandedChannels(): BrandedChannelList
    {
        if (!$this->_brandedChannels) {
            $this->_brandedChannels = new BrandedChannelList($this->version, $this->solution['businessSid'], $this->solution['sid']);
        }
        return $this->_brandedChannels;
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
        return '[Twilio.Preview.TrustedComms.BrandContext ' . implode(' ', $context) . ']';
    }
}