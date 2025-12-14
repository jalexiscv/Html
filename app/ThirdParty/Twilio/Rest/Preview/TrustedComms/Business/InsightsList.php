<?php

namespace Twilio\Rest\Preview\TrustedComms\Business;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Preview\TrustedComms\Business\Insights\ImpressionsRateContext;
use Twilio\Rest\Preview\TrustedComms\Business\Insights\ImpressionsRateList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function property_exists;
use function ucfirst;

class InsightsList extends ListResource
{
    protected $_impressionsRate = null;

    public function __construct(Version $version, string $businessSid)
    {
        parent::__construct($version);
        $this->solution = ['businessSid' => $businessSid,];
    }

    protected function getImpressionsRate(): ImpressionsRateList
    {
        if (!$this->_impressionsRate) {
            $this->_impressionsRate = new ImpressionsRateList($this->version, $this->solution['businessSid']);
        }
        return $this->_impressionsRate;
    }

    public function __get(string $name)
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
        return '[Twilio.Preview.TrustedComms.InsightsList]';
    }
}