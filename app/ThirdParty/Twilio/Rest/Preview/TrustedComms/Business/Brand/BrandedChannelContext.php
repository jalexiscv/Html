<?php

namespace Twilio\Rest\Preview\TrustedComms\Business\Brand;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Preview\TrustedComms\Business\Brand\BrandedChannel\ChannelList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class BrandedChannelContext extends InstanceContext
{
    protected $_channels;

    public function __construct(Version $version, $businessSid, $brandSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['businessSid' => $businessSid, 'brandSid' => $brandSid, 'sid' => $sid,];
        $this->uri = '/Businesses/' . rawurlencode($businessSid) . '/Brands/' . rawurlencode($brandSid) . '/BrandedChannels/' . rawurlencode($sid) . '';
    }

    public function fetch(): BrandedChannelInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new BrandedChannelInstance($this->version, $payload, $this->solution['businessSid'], $this->solution['brandSid'], $this->solution['sid']);
    }

    protected function getChannels(): ChannelList
    {
        if (!$this->_channels) {
            $this->_channels = new ChannelList($this->version, $this->solution['businessSid'], $this->solution['brandSid'], $this->solution['sid']);
        }
        return $this->_channels;
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
        return '[Twilio.Preview.TrustedComms.BrandedChannelContext ' . implode(' ', $context) . ']';
    }
}