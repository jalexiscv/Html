<?php

namespace Twilio\Rest;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Rest\Numbers\V2;
use Twilio\Rest\Numbers\V2\RegulatoryComplianceList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class Numbers extends Domain
{
    protected $_v2;

    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->baseUrl = 'https://numbers.twilio.com';
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

    protected function getRegulatoryCompliance(): RegulatoryComplianceList
    {
        return $this->v2->regulatoryCompliance;
    }

    public function __toString(): string
    {
        return '[Twilio.Numbers]';
    }
}