<?php

namespace Twilio\Rest\Sync\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Sync\V1\Service\SyncList\SyncListItemContext;
use Twilio\Rest\Sync\V1\Service\SyncList\SyncListItemList;
use Twilio\Rest\Sync\V1\Service\SyncList\SyncListPermissionContext;
use Twilio\Rest\Sync\V1\Service\SyncList\SyncListPermissionList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class SyncListContext extends InstanceContext
{
    protected $_syncListItems;
    protected $_syncListPermissions;

    public function __construct(Version $version, $serviceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Lists/' . rawurlencode($sid) . '';
    }

    public function fetch(): SyncListInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new SyncListInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function update(array $options = []): SyncListInstance
    {
        $options = new Values($options);
        $data = Values::of(['Ttl' => $options['ttl'], 'CollectionTtl' => $options['collectionTtl'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new SyncListInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    protected function getSyncListItems(): SyncListItemList
    {
        if (!$this->_syncListItems) {
            $this->_syncListItems = new SyncListItemList($this->version, $this->solution['serviceSid'], $this->solution['sid']);
        }
        return $this->_syncListItems;
    }

    protected function getSyncListPermissions(): SyncListPermissionList
    {
        if (!$this->_syncListPermissions) {
            $this->_syncListPermissions = new SyncListPermissionList($this->version, $this->solution['serviceSid'], $this->solution['sid']);
        }
        return $this->_syncListPermissions;
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
        return '[Twilio.Sync.V1.SyncListContext ' . implode(' ', $context) . ']';
    }
}