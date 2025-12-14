<?php

namespace Twilio\Rest\Verify\V2\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Verify\V2\Service\Entity\ChallengeContext;
use Twilio\Rest\Verify\V2\Service\Entity\ChallengeList;
use Twilio\Rest\Verify\V2\Service\Entity\FactorContext;
use Twilio\Rest\Verify\V2\Service\Entity\FactorList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class EntityContext extends InstanceContext
{
    protected $_factors;
    protected $_challenges;

    public function __construct(Version $version, $serviceSid, $identity)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'identity' => $identity,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Entities/' . rawurlencode($identity) . '';
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function fetch(): EntityInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new EntityInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['identity']);
    }

    protected function getFactors(): FactorList
    {
        if (!$this->_factors) {
            $this->_factors = new FactorList($this->version, $this->solution['serviceSid'], $this->solution['identity']);
        }
        return $this->_factors;
    }

    protected function getChallenges(): ChallengeList
    {
        if (!$this->_challenges) {
            $this->_challenges = new ChallengeList($this->version, $this->solution['serviceSid'], $this->solution['identity']);
        }
        return $this->_challenges;
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
        return '[Twilio.Verify.V2.EntityContext ' . implode(' ', $context) . ']';
    }
}