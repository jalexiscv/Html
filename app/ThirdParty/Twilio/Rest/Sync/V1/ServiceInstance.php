<?php

namespace Twilio\Rest\Sync\V1;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Sync\V1\Service\DocumentList;
use Twilio\Rest\Sync\V1\Service\SyncListList;
use Twilio\Rest\Sync\V1\Service\SyncMapList;
use Twilio\Rest\Sync\V1\Service\SyncStreamList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ServiceInstance extends InstanceResource
{
    protected $_documents;
    protected $_syncLists;
    protected $_syncMaps;
    protected $_syncStreams;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'), 'webhookUrl' => Values::array_get($payload, 'webhook_url'), 'webhooksFromRestEnabled' => Values::array_get($payload, 'webhooks_from_rest_enabled'), 'reachabilityWebhooksEnabled' => Values::array_get($payload, 'reachability_webhooks_enabled'), 'aclEnabled' => Values::array_get($payload, 'acl_enabled'), 'reachabilityDebouncingEnabled' => Values::array_get($payload, 'reachability_debouncing_enabled'), 'reachabilityDebouncingWindow' => Values::array_get($payload, 'reachability_debouncing_window'), 'links' => Values::array_get($payload, 'links'),];
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

    protected function getDocuments(): DocumentList
    {
        return $this->proxy()->documents;
    }

    protected function getSyncLists(): SyncListList
    {
        return $this->proxy()->syncLists;
    }

    protected function getSyncMaps(): SyncMapList
    {
        return $this->proxy()->syncMaps;
    }

    protected function getSyncStreams(): SyncStreamList
    {
        return $this->proxy()->syncStreams;
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
        return '[Twilio.Sync.V1.ServiceInstance ' . implode(' ', $context) . ']';
    }
}