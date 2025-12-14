<?php

namespace Twilio\Rest\Preview\Sync;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Preview\Sync\Service\DocumentContext;
use Twilio\Rest\Preview\Sync\Service\DocumentList;
use Twilio\Rest\Preview\Sync\Service\SyncListContext;
use Twilio\Rest\Preview\Sync\Service\SyncListList;
use Twilio\Rest\Preview\Sync\Service\SyncMapContext;
use Twilio\Rest\Preview\Sync\Service\SyncMapList;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class ServiceContext extends InstanceContext
{
    protected $_documents;
    protected $_syncLists;
    protected $_syncMaps;

    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($sid) . '';
    }

    public function fetch(): ServiceInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ServiceInstance($this->version, $payload, $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function update(array $options = []): ServiceInstance
    {
        $options = new Values($options);
        $data = Values::of(['WebhookUrl' => $options['webhookUrl'], 'FriendlyName' => $options['friendlyName'], 'ReachabilityWebhooksEnabled' => Serialize::booleanToString($options['reachabilityWebhooksEnabled']), 'AclEnabled' => Serialize::booleanToString($options['aclEnabled']),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new ServiceInstance($this->version, $payload, $this->solution['sid']);
    }

    protected function getDocuments(): DocumentList
    {
        if (!$this->_documents) {
            $this->_documents = new DocumentList($this->version, $this->solution['sid']);
        }
        return $this->_documents;
    }

    protected function getSyncLists(): SyncListList
    {
        if (!$this->_syncLists) {
            $this->_syncLists = new SyncListList($this->version, $this->solution['sid']);
        }
        return $this->_syncLists;
    }

    protected function getSyncMaps(): SyncMapList
    {
        if (!$this->_syncMaps) {
            $this->_syncMaps = new SyncMapList($this->version, $this->solution['sid']);
        }
        return $this->_syncMaps;
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
        return '[Twilio.Preview.Sync.ServiceContext ' . implode(' ', $context) . ']';
    }
}