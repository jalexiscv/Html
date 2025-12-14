<?php

namespace Twilio\Rest\Preview\TrustedComms;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Rest\Preview\TrustedComms\Business\BrandList;
use Twilio\Rest\Preview\TrustedComms\Business\InsightsList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class BusinessInstance extends InstanceResource
{
    protected $_brands;
    protected $_insights;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'sid' => Values::array_get($payload, 'sid'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): BusinessContext
    {
        if (!$this->context) {
            $this->context = new BusinessContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): BusinessInstance
    {
        return $this->proxy()->fetch();
    }

    protected function getBrands(): BrandList
    {
        return $this->proxy()->brands;
    }

    protected function getInsights(): InsightsList
    {
        return $this->proxy()->insights;
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
        return '[Twilio.Preview.TrustedComms.BusinessInstance ' . implode(' ', $context) . ']';
    }
}