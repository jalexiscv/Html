<?php

namespace Twilio\Rest;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Rest\Accounts\V1;
use Twilio\Rest\Accounts\V1\AuthTokenPromotionContext;
use Twilio\Rest\Accounts\V1\AuthTokenPromotionList;
use Twilio\Rest\Accounts\V1\CredentialList;
use Twilio\Rest\Accounts\V1\SecondaryAuthTokenContext;
use Twilio\Rest\Accounts\V1\SecondaryAuthTokenList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class Accounts extends Domain
{
    protected $_v1;

    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->baseUrl = 'https://accounts.twilio.com';
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

    public function __toString(): string
    {
        return '[Twilio.Accounts]';
    }

    protected function getV1(): V1
    {
        if (!$this->_v1) {
            $this->_v1 = new V1($this);
        }
        return $this->_v1;
    }

    protected function getAuthTokenPromotion(): AuthTokenPromotionList
    {
        return $this->v1->authTokenPromotion;
    }

    protected function contextAuthTokenPromotion(): AuthTokenPromotionContext
    {
        return $this->v1->authTokenPromotion();
    }

    protected function getCredentials(): CredentialList
    {
        return $this->v1->credentials;
    }

    protected function getSecondaryAuthToken(): SecondaryAuthTokenList
    {
        return $this->v1->secondaryAuthToken;
    }

    protected function contextSecondaryAuthToken(): SecondaryAuthTokenContext
    {
        return $this->v1->secondaryAuthToken();
    }
}