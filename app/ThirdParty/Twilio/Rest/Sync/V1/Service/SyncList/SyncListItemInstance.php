<?php

namespace Twilio\Rest\Sync\V1\Service\SyncList;

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

class SyncListItemInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $serviceSid, string $listSid, int $index = null)
    {
        parent::__construct($version);
        $this->properties = ['index' => Values::array_get($payload, 'index'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'listSid' => Values::array_get($payload, 'list_sid'), 'url' => Values::array_get($payload, 'url'), 'revision' => Values::array_get($payload, 'revision'), 'data' => Values::array_get($payload, 'data'), 'dateExpires' => Deserialize::dateTime(Values::array_get($payload, 'date_expires')), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'createdBy' => Values::array_get($payload, 'created_by'),];
        $this->solution = ['serviceSid' => $serviceSid, 'listSid' => $listSid, 'index' => $index ?: $this->properties['index'],];
    }

    protected function proxy(): SyncListItemContext
    {
        if (!$this->context) {
            $this->context = new SyncListItemContext($this->version, $this->solution['serviceSid'], $this->solution['listSid'], $this->solution['index']);
        }
        return $this->context;
    }

    public function fetch(): SyncListItemInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(array $options = []): bool
    {
        return $this->proxy()->delete($options);
    }

    public function update(array $options = []): SyncListItemInstance
    {
        return $this->proxy()->update($options);
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
        return '[Twilio.Sync.V1.SyncListItemInstance ' . implode(' ', $context) . ']';
    }
}