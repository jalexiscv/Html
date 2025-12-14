<?php

namespace Twilio\Rest\Preview\Sync\Service\SyncMap;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class SyncMapItemContext extends InstanceContext
{
    public function __construct(Version $version, $serviceSid, $mapSid, $key)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'mapSid' => $mapSid, 'key' => $key,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Maps/' . rawurlencode($mapSid) . '/Items/' . rawurlencode($key) . '';
    }

    public function fetch(): SyncMapItemInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new SyncMapItemInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['mapSid'], $this->solution['key']);
    }

    public function delete(array $options = []): bool
    {
        $options = new Values($options);
        $headers = Values::of(['If-Match' => $options['ifMatch'],]);
        return $this->version->delete('DELETE', $this->uri, [], [], $headers);
    }

    public function update(array $data, array $options = []): SyncMapItemInstance
    {
        $options = new Values($options);
        $data = Values::of(['Data' => Serialize::jsonObject($data),]);
        $headers = Values::of(['If-Match' => $options['ifMatch'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data, $headers);
        return new SyncMapItemInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['mapSid'], $this->solution['key']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Preview.Sync.SyncMapItemContext ' . implode(' ', $context) . ']';
    }
}