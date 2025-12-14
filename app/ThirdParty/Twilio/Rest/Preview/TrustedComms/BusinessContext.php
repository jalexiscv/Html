<?php

namespace Twilio\Rest\Preview\TrustedComms;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Preview\TrustedComms\Business\BrandContext;
use Twilio\Rest\Preview\TrustedComms\Business\BrandList;
use Twilio\Rest\Preview\TrustedComms\Business\InsightsList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class BusinessContext extends InstanceContext
{
    protected $_brands;
    protected $_insights;

    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Businesses/' . rawurlencode($sid) . '';
    }

    public function fetch(): BusinessInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new BusinessInstance($this->version, $payload, $this->solution['sid']);
    }

    protected function getBrands(): BrandList
    {
        if (!$this->_brands) {
            $this->_brands = new BrandList($this->version, $this->solution['sid']);
        }
        return $this->_brands;
    }

    protected function getInsights(): InsightsList
    {
        if (!$this->_insights) {
            $this->_insights = new InsightsList($this->version, $this->solution['sid']);
        }
        return $this->_insights;
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
        return '[Twilio.Preview.TrustedComms.BusinessContext ' . implode(' ', $context) . ']';
    }
}