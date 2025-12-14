<?php

namespace Twilio\Rest\Preview\Sync\Service\SyncMap;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class SyncMapItemInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid, string $mapSid, string $key = null)
    {
        parent::__construct($version);
        $this->properties = ['key' => Values::array_get($payload, 'key'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'mapSid' => Values::array_get($payload, 'map_sid'), 'url' => Values::array_get($payload, 'url'), 'revision' => Values::array_get($payload, 'revision'), 'data' => Values::array_get($payload, 'data'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'createdBy' => Values::array_get($payload, 'created_by'),];
        $this->solution = ['serviceSid' => $serviceSid, 'mapSid' => $mapSid, 'key' => $key ?: $this->properties['key'],];
    }

    protected function proxy(): SyncMapItemContext
    {
        if (!$this->context) {
            $this->context = new SyncMapItemContext($this->version, $this->solution['serviceSid'], $this->solution['mapSid'], $this->solution['key']);
        }
        return $this->context;
    }

    public function fetch(): SyncMapItemInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(array $options = []): bool
    {
        return $this->proxy()->delete($options);
    }

    public function update(array $data, array $options = []): SyncMapItemInstance
    {
        return $this->proxy()->update($data, $options);
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
        return '[Twilio.Preview.Sync.SyncMapItemInstance ' . implode(' ', $context) . ']';
    }
}