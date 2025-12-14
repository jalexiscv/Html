<?php

namespace Twilio\Rest\Proxy\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class ShortCodeContext extends InstanceContext
{
    public function __construct(Version $version, $serviceSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'sid' => $sid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/ShortCodes/' . rawurlencode($sid) . '';
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function fetch(): ShortCodeInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ShortCodeInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    public function update(array $options = []): ShortCodeInstance
    {
        $options = new Values($options);
        $data = Values::of(['IsReserved' => Serialize::booleanToString($options['isReserved']),]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new ShortCodeInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Proxy.V1.ShortCodeContext ' . implode(' ', $context) . ']';
    }
}