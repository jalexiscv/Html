<?php

namespace Twilio\Rest\Sync\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Sync\V1\Service\DocumentContext;
use Twilio\Rest\Sync\V1\Service\DocumentList;
use Twilio\Rest\Sync\V1\Service\SyncListContext;
use Twilio\Rest\Sync\V1\Service\SyncListList;
use Twilio\Rest\Sync\V1\Service\SyncMapContext;
use Twilio\Rest\Sync\V1\Service\SyncMapList;
use Twilio\Rest\Sync\V1\Service\SyncStreamContext;
use Twilio\Rest\Sync\V1\Service\SyncStreamList;
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
    protected $_syncStreams;

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
        $data = Values::of(['WebhookUrl' => $options['webhookUrl'], 'FriendlyName' => $options['friendlyName'], 'ReachabilityWebhooksEnabled' => Serialize::booleanToString($options['reachabilityWebhooksEnabled']), 'AclEnabled' => Serialize::booleanToString($options['aclEnabled']), 'ReachabilityDebouncingEnabled' => Serialize::booleanToString($options['reachabilityDebouncingEnabled']), 'ReachabilityDebouncingWindow' => $options['reachabilityDebouncingWindow'], 'WebhooksFromRestEnabled' => Serialize::booleanToString($options['webhooksFromRestEnabled']),]);
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

    protected function getSyncStreams(): SyncStreamList
    {
        if (!$this->_syncStreams) {
            $this->_syncStreams = new SyncStreamList($this->version, $this->solution['sid']);
        }
        return $this->_syncStreams;
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
        return '[Twilio.Sync.V1.ServiceContext ' . implode(' ', $context) . ']';
    }
}