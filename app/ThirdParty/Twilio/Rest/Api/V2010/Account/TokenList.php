<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function rawurlencode;

class TokenList extends ListResource
{
    public function __construct(Version $version, string $accountSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Tokens.json';
    }

    public function create(array $options = []): TokenInstance
    {
        $options = new Values($options);
        $data = Values::of(['Ttl' => $options['ttl'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new TokenInstance($this->version, $payload, $this->solution['accountSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.TokenList]';
    }
}