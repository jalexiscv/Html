<?php

namespace Twilio\Rest\Sync\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Sync\V1\Service\SyncMap\SyncMapItemContext;
use Twilio\Rest\Sync\V1\Service\SyncMap\SyncMapItemList;
use Twilio\Rest\Sync\V1\Service\SyncMap\SyncMapPermissionContext;
use Twilio\Rest\Sync\V1\Service\SyncMap\SyncMapPermissionList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class SyncMapContext extends InstanceContext
{
    protected $_syncMapItems;
    protected $_syncMapPermissions;

    public function __construct(Version $version, $serviceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Maps/' . rawurlencode($sid) . '';
    }

    public function fetch(): SyncMapInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new SyncMapInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function update(array $options = []): SyncMapInstance
    {
        $options = new Values($options);
        $data = Values::of(['Ttl' => $options['ttl'], 'CollectionTtl' => $options['collectionTtl'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new SyncMapInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    protected function getSyncMapItems(): SyncMapItemList
    {
        if (!$this->_syncMapItems) {
            $this->_syncMapItems = new SyncMapItemList($this->version, $this->solution['serviceSid'], $this->solution['sid']);
        }
        return $this->_syncMapItems;
    }

    protected function getSyncMapPermissions(): SyncMapPermissionList
    {
        if (!$this->_syncMapPermissions) {
            $this->_syncMapPermissions = new SyncMapPermissionList($this->version, $this->solution['serviceSid'], $this->solution['sid']);
        }
        return $this->_syncMapPermissions;
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
        return '[Twilio.Sync.V1.SyncMapContext ' . implode(' ', $context) . ']';
    }
}