<?php

namespace Twilio\Jwt\Grants;
class VideoGrant implements Grant
{
    private $room;

    public function getRoom(): string
    {
        return $this->room;
    }

    public function setRoom(string $roomSidOrName): self
    {
        $this->room = $roomSidOrName;
        return $this;
    }

    public function getGrantKey(): string
    {
        return 'video';
    }

    public function getPayload(): array
    {
        $payload = [];
        if ($this->room) {
            $payload['room'] = $this->room;
        }
        return $payload;
    }
}