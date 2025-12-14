<?php

namespace Twilio\Rest\Preview\TrustedComms\Business;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Rest\Preview\TrustedComms\Business\Brand\BrandedChannelList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class BrandInstance extends InstanceResource
{
    protected $_brandedChannels;

    public function __construct(Version $version, array $payload, string $businessSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'businessSid' => Values::array_get($payload, 'business_sid'), 'sid' => Values::array_get($payload, 'sid'), 'links' => Values::array_get($payload, 'links'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['businessSid' => $businessSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): BrandContext
    {
        if (!$this->context) {
            $this->context = new BrandContext($this->version, $this->solution['businessSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): BrandInstance
    {
        return $this->proxy()->fetch();
    }

    protected function getBrandedChannels(): BrandedChannelList
    {
        return $this->proxy()->brandedChannels;
    }

    public function __get(string $name)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown property: ' . $name);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Preview.TrustedComms.BrandInstance ' . implode(' ', $context) . ']';
    }
}