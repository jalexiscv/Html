<?php

namespace Twilio\Rest\Proxy\V1\Service\Session;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ParticipantOptions
{
    public static function create(string $friendlyName = Values::NONE, string $proxyIdentifier = Values::NONE, string $proxyIdentifierSid = Values::NONE, bool $failOnParticipantConflict = Values::NONE): CreateParticipantOptions
    {
        return new CreateParticipantOptions($friendlyName, $proxyIdentifier, $proxyIdentifierSid, $failOnParticipantConflict);
    }
}

class CreateParticipantOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $proxyIdentifier = Values::NONE, string $proxyIdentifierSid = Values::NONE, bool $failOnParticipantConflict = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['proxyIdentifier'] = $proxyIdentifier;
        $this->options['proxyIdentifierSid'] = $proxyIdentifierSid;
        $this->options['failOnParticipantConflict'] = $failOnParticipantConflict;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setProxyIdentifier(string $proxyIdentifier): self
    {
        $this->options['proxyIdentifier'] = $proxyIdentifier;
        return $this;
    }

    public function setProxyIdentifierSid(string $proxyIdentifierSid): self
    {
        $this->options['proxyIdentifierSid'] = $proxyIdentifierSid;
        return $this;
    }

    public function setFailOnParticipantConflict(bool $failOnParticipantConflict): self
    {
        $this->options['failOnParticipantConflict'] = $failOnParticipantConflict;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Proxy.V1.CreateParticipantOptions ' . $options . ']';
    }
}