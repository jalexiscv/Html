<?php

namespace Twilio\Jwt\Grants;
interface Grant
{
    public function getGrantKey(): string;

    public function getPayload(): array;
}