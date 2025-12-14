<?php

namespace Twilio\Jwt\Grants;
class VoiceGrant implements Grant
{
    private $incomingAllow;
    private $outgoingApplicationSid;
    private $outgoingApplicationParams;
    private $pushCredentialSid;
    private $endpointId;

    public function getIncomingAllow(): bool
    {
        return $this->incomingAllow;
    }

    public function setIncomingAllow(bool $incomingAllow): self
    {
        $this->incomingAllow = $incomingAllow;
        return $this;
    }

    public function getOutgoingApplicationSid(): string
    {
        return $this->outgoingApplicationSid;
    }

    public function setOutgoingApplicationSid(string $outgoingApplicationSid): self
    {
        $this->outgoingApplicationSid = $outgoingApplicationSid;
        return $this;
    }

    public function getOutgoingApplicationParams(): array
    {
        return $this->outgoingApplicationParams;
    }

    public function setOutgoingApplication(string $sid, array $params): self
    {
        $this->outgoingApplicationSid = $sid;
        $this->outgoingApplicationParams = $params;
        return $this;
    }

    public function getPushCredentialSid(): string
    {
        return $this->pushCredentialSid;
    }

    public function setPushCredentialSid(string $pushCredentialSid): self
    {
        $this->pushCredentialSid = $pushCredentialSid;
        return $this;
    }

    public function getEndpointId(): string
    {
        return $this->endpointId;
    }

    public function setEndpointId(string $endpointId): self
    {
        $this->endpointId = $endpointId;
        return $this;
    }

    public function getGrantKey(): string
    {
        return 'voice';
    }

    public function getPayload(): array
    {
        $payload = [];
        if ($this->incomingAllow === true) {
            $incoming = [];
            $incoming['allow'] = true;
            $payload['incoming'] = $incoming;
        }
        if ($this->outgoingApplicationSid) {
            $outgoing = [];
            $outgoing['application_sid'] = $this->outgoingApplicationSid;
            if ($this->outgoingApplicationParams) {
                $outgoing['params'] = $this->outgoingApplicationParams;
            }
            $payload['outgoing'] = $outgoing;
        }
        if ($this->pushCredentialSid) {
            $payload['push_credential_sid'] = $this->pushCredentialSid;
        }
        if ($this->endpointId) {
            $payload['endpoint_id'] = $this->endpointId;
        }
        return $payload;
    }
}