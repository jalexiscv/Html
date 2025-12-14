<?php

namespace Twilio\Rest\Events\V1\Subscription;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class SubscribedEventContext extends InstanceContext
{
    public function __construct(Version $version, $subscriptionSid, $type)
    {
        parent::__construct($version);
        $this->solution = ['subscriptionSid' => $subscriptionSid, 'type' => $type,];
        $this->uri = '/Subscriptions/' . rawurlencode($subscriptionSid) . '/SubscribedEvents/' . rawurlencode($type) . '';
    }

    public function update(int $version): SubscribedEventInstance
    {
        $data = Values::of(['Version' => $version,]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new SubscribedEventInstance($this->version, $payload, $this->solution['subscriptionSid'], $this->solution['type']);
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
        return '[Twilio.Events.V1.SubscribedEventContext ' . implode(' ', $context) . ']';
    }
}