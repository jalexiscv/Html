<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Values;
use Twilio\Version;
use function rawurlencode;

class BalanceList extends ListResource
{
    public function __construct(Version $version, string $accountSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Balance.json';
    }

    public function fetch(): BalanceInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new BalanceInstance($this->version, $payload, $this->solution['accountSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.BalanceList]';
    }
}