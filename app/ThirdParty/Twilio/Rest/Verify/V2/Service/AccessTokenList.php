<?php

namespace Twilio\Rest\Verify\V2\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Values;
use Twilio\Version;
use function rawurlencode;

class AccessTokenList extends ListResource
{
    public function __construct(Version $version, string $serviceSid)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/AccessTokens';
    }

    public function create(string $identity, string $factorType): AccessTokenInstance
    {
        $data = Values::of(['Identity' => $identity, 'FactorType' => $factorType,]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new AccessTokenInstance($this->version, $payload, $this->solution['serviceSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Verify.V2.AccessTokenList]';
    }
}