<?php

namespace Twilio\Jwt\Grants;
class TaskRouterGrant implements Grant
{
    private $workspaceSid;
    private $workerSid;
    private $role;

    public function getWorkspaceSid(): string
    {
        return $this->workspaceSid;
    }

    public function setWorkspaceSid(string $workspaceSid): self
    {
        $this->workspaceSid = $workspaceSid;
        return $this;
    }

    public function getWorkerSid(): string
    {
        return $this->workerSid;
    }

    public function setWorkerSid(string $workerSid): self
    {
        $this->workerSid = $workerSid;
        return $this;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getGrantKey(): string
    {
        return 'task_router';
    }

    public function getPayload(): array
    {
        $payload = [];
        if ($this->workspaceSid) {
            $payload['workspace_sid'] = $this->workspaceSid;
        }
        if ($this->workerSid) {
            $payload['worker_sid'] = $this->workerSid;
        }
        if ($this->role) {
            $payload['role'] = $this->role;
        }
        return $payload;
    }
}