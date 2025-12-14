<?php

namespace Twilio\Rest\FlexApi\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class WebChannelContext extends InstanceContext
{
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/WebChannels/' . rawurlencode($sid) . '';
    }

    public function fetch(): WebChannelInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new WebChannelInstance($this->version, $payload, $this->solution['sid']);
    }

    public function update(array $options = []): WebChannelInstance
    {
        $options = new Values($options);
        $data = Values::of(['ChatStatus' => $options['chatStatus'], 'PostEngagementData' => $options['postEngagementData'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new WebChannelInstance($this->version, $payload, $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.FlexApi.V1.WebChannelContext ' . implode(' ', $context) . ']';
    }
}