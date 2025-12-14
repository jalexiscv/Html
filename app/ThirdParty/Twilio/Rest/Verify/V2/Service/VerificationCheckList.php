<?php

namespace Twilio\Rest\Verify\V2\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function rawurlencode;

class VerificationCheckList extends ListResource
{
    public function __construct(Version $version, string $serviceSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/VerificationCheck';
    }

    public function create(string $code, array $options = []): VerificationCheckInstance
    {
        $options = new Values($options);
        $data = Values::of(['Code' => $code, 'To' => $options['to'], 'VerificationSid' => $options['verificationSid'], 'Amount' => $options['amount'], 'Payee' => $options['payee'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new VerificationCheckInstance($this->version, $payload, $this->solution['serviceSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Verify.V2.VerificationCheckList]';
    }
}