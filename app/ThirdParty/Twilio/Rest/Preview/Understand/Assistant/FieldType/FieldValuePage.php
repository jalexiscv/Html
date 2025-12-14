<?php

namespace Twilio\Rest\Preview\Understand\Assistant\FieldType;

use Twilio\Http\Response;
use Twilio\Page;
use Twilio\Version;

class FieldValuePage extends Page
{
    public function __construct(Version $version, Response $response, array $solution)
    {
        parent::__construct($version, $response);
        $this->solution = $solution;
    }

    public function buildInstance(array $payload): FieldValueInstance
    {
        return new FieldValueInstance($this->version, $payload, $this->solution['assistantSid'], $this->solution['fieldTypeSid']);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.Understand.FieldValuePage]';
    }
}