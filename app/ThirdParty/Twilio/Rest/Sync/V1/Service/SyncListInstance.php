<?php

namespace Twilio\Rest\Sync\V1\Service;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Sync\V1\Service\SyncList\SyncListItemList;
use Twilio\Rest\Sync\V1\Service\SyncList\SyncListPermissionList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class SyncListInstance extends InstanceResource
{
    protected $_syncListItems;
    protected $_syncListPermissions;

    public function __construct(Version $version, array $payload, string $serviceSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'serviceSid' => Values::array_get($payload, 'service_sid'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'), 'revision' => Values::array_get($payload, 'revision'), 'dateExpires' => Deserialize::dateTime(Values::array_get($payload, 'date_expires')), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'createdBy' => Values::array_get($payload, 'created_by'),];
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): SyncListContext
    {
        if (!$this->context) {
            $this->context = new SyncListContext($this->version, $this->solution['serviceSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): SyncListInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function update(array $options = []): SyncListInstance
    {
        return $this->proxy()->update($options);
    }

    protected function getSyncListItems(): SyncListItemList
    {
        return $this->proxy()->syncListItems;
    }

    protected function getSyncListPermissions(): SyncListPermissionList
    {
        return $this->proxy()->syncListPermissions;
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
        return '[Twilio.Sync.V1.SyncListInstance ' . implode(' ', $context) . ']';
    }
}