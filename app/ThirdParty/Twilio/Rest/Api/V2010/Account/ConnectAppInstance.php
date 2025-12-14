<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ConnectAppInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $accountSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'authorizeRedirectUrl' => Values::array_get($payload, 'authorize_redirect_url'), 'companyName' => Values::array_get($payload, 'company_name'), 'deauthorizeCallbackMethod' => Values::array_get($payload, 'deauthorize_callback_method'), 'deauthorizeCallbackUrl' => Values::array_get($payload, 'deauthorize_callback_url'), 'description' => Values::array_get($payload, 'description'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'homepageUrl' => Values::array_get($payload, 'homepage_url'), 'permissions' => Values::array_get($payload, 'permissions'), 'sid' => Values::array_get($payload, 'sid'), 'uri' => Values::array_get($payload, 'uri'),];
        $this->solution = ['accountSid' => $accountSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): ConnectAppContext
    {
        if (!$this->context) {
            $this->context = new ConnectAppContext($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): ConnectAppInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): ConnectAppInstance
    {
        return $this->proxy()->update($options);
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
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
        return '[Twilio.Api.V2010.ConnectAppInstance ' . implode(' ', $context) . ']';
    }
}