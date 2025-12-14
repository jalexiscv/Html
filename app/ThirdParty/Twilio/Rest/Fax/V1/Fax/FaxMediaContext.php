<?php

namespace Twilio\Rest\Fax\V1\Fax;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class FaxMediaContext extends InstanceContext
{
    public function __construct(Version $version, $faxSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['faxSid' => $faxSid, 'sid' => $sid,];
        $this->uri = '/Faxes/' . rawurlencode($faxSid) . '/Media/' . rawurlencode($sid) . '';
    }

    public function fetch(): FaxMediaInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new FaxMediaInstance($this->version, $payload, $this->solution['faxSid'], $this->solution['sid']);
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
        return '[Twilio.Fax.V1.FaxMediaContext ' . implode(' ', $context) . ']';
    }
}