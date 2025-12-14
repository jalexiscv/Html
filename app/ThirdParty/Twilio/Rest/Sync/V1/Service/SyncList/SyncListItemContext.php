<?php

namespace Twilio\Rest\Sync\V1\Service\SyncList;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class SyncListItemContext extends InstanceContext
{
    public function __construct(Version $version, $serviceSid, $listSid, $index)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'listSid' => $listSid, 'index' => $index,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Lists/' . rawurlencode($listSid) . '/Items/' . rawurlencode($index) . '';
    }

    public function fetch(): SyncListItemInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new SyncListItemInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['listSid'], $this->solution['index']);
    }

    public function delete(array $options = []): bool
    {
        $options = new Values($options);
        $headers = Values::of(['If-Match' => $options['ifMatch'],]);
        return $this->version->delete('DELETE', $this->uri, [], [], $headers);
    }

    public function update(array $options = []): SyncListItemInstance
    {
        $options = new Values($options);
        $data = Values::of(['Data' => Serialize::jsonObject($options['data']), 'Ttl' => $options['ttl'], 'ItemTtl' => $options['itemTtl'], 'CollectionTtl' => $options['collectionTtl'],]);
        $headers = Values::of(['If-Match' => $options['ifMatch'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data, $headers);
        return new SyncListItemInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['listSid'], $this->solution['index']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Sync.V1.SyncListItemContext ' . implode(' ', $context) . ']';
    }
}