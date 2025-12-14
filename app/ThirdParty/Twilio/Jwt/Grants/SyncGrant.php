<?php

namespace Twilio\Jwt\Grants;
class SyncGrant implements Grant
{
    private $serviceSid;
    private $endpointId;
    private $deploymentRoleSid;
    private $pushCredentialSid;

    public function getServiceSid(): string
    {
        return $this->serviceSid;
    }

    public function setServiceSid(string $serviceSid): self
    {
        $this->serviceSid = $serviceSid;
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

    public function getDeploymentRoleSid(): string
    {
        return $this->deploymentRoleSid;
    }

    public function setDeploymentRoleSid(string $deploymentRoleSid): self
    {
        $this->deploymentRoleSid = $deploymentRoleSid;
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

    public function getGrantKey(): string
    {
        return 'data_sync';
    }

    public function getPayload(): array
    {
        $payload = [];
        if ($this->serviceSid) {
            $payload['service_sid'] = $this->serviceSid;
        }
        if ($this->endpointId) {
            $payload['endpoint_id'] = $this->endpointId;
        }
        if ($this->deploymentRoleSid) {
            $payload['deployment_role_sid'] = $this->deploymentRoleSid;
        }
        if ($this->pushCredentialSid) {
            $payload['push_credential_sid'] = $this->pushCredentialSid;
        }
        return $payload;
    }
}