<?php

namespace Twilio\Rest\Serverless\V1;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Serverless\V1\Service\AssetList;
use Twilio\Rest\Serverless\V1\Service\BuildList;
use Twilio\Rest\Serverless\V1\Service\EnvironmentList;
use Twilio\Rest\Serverless\V1\Service\FunctionList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ServiceInstance extends InstanceResource
{
    protected $_environments;
    protected $_functions;
    protected $_assets;
    protected $_builds;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'includeCredentials' => Values::array_get($payload, 'include_credentials'), 'uiEditable' => Values::array_get($payload, 'ui_editable'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): ServiceContext
    {
        if (!$this->context) {
            $this->context = new ServiceContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): ServiceInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function update(array $options = []): ServiceInstance
    {
        return $this->proxy()->update($options);
    }

    protected function getEnvironments(): EnvironmentList
    {
        return $this->proxy()->environments;
    }

    protected function getFunctions(): FunctionList
    {
        return $this->proxy()->functions;
    }

    protected function getAssets(): AssetList
    {
        return $this->proxy()->assets;
    }

    protected function getBuilds(): BuildList
    {
        return $this->proxy()->builds;
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
        return '[Twilio.Serverless.V1.ServiceInstance ' . implode(' ', $context) . ']';
    }
}