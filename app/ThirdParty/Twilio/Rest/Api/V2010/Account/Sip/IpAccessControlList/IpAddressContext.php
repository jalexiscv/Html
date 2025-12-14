<?php

namespace Twilio\Rest\Api\V2010\Account\Sip\IpAccessControlList;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class IpAddressContext extends InstanceContext
{
    public function __construct(Version $version, $accountSid, $ipAccessControlListSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'ipAccessControlListSid' => $ipAccessControlListSid, 'sid' => $sid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/SIP/IpAccessControlLists/' . rawurlencode($ipAccessControlListSid) . '/IpAddresses/' . rawurlencode($sid) . '.json';
    }

    public function fetch(): IpAddressInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new IpAddressInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['ipAccessControlListSid'], $this->solution['sid']);
    }

    public function update(array $options = []): IpAddressInstance
    {
        $options = new Values($options);
        $data = Values::of(['IpAddress' => $options['ipAddress'], 'FriendlyName' => $options['friendlyName'], 'CidrPrefixLength' => $options['cidrPrefixLength'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new IpAddressInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['ipAccessControlListSid'], $this->solution['sid']);
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
        return '[Twilio.Api.V2010.IpAddressContext ' . implode(' ', $context) . ']';
    }
}