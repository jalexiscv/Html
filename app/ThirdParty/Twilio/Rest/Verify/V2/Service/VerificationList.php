<?php

namespace Twilio\Rest\Verify\V2\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function rawurlencode;

class VerificationList extends ListResource
{
    public function __construct(Version $version, string $serviceSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Verifications';
    }

    public function create(string $to, string $channel, array $options = []): VerificationInstance
    {
        $options = new Values($options);
        $data = Values::of(['To' => $to, 'Channel' => $channel, 'CustomFriendlyName' => $options['customFriendlyName'], 'CustomMessage' => $options['customMessage'], 'SendDigits' => $options['sendDigits'], 'Locale' => $options['locale'], 'CustomCode' => $options['customCode'], 'Amount' => $options['amount'], 'Payee' => $options['payee'], 'RateLimits' => Serialize::jsonObject($options['rateLimits']), 'ChannelConfiguration' => Serialize::jsonObject($options['channelConfiguration']), 'AppHash' => $options['appHash'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new VerificationInstance($this->version, $payload, $this->solution['serviceSid']);
    }

    public function getContext(string $sid): VerificationContext
    {
        return new VerificationContext($this->version, $this->solution['serviceSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Verify.V2.VerificationList]';
    }
}