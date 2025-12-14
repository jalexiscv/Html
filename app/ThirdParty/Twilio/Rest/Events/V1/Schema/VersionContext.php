<?php

namespace Twilio\Rest\Events\V1\Schema;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class VersionContext extends InstanceContext
{
    public function __construct(Version $version, $id, $schemaVersion)
    {
        parent::__construct($version);
        $this->solution = ['id' => $id, 'schemaVersion' => $schemaVersion,];
        $this->uri = '/Schemas/' . rawurlencode($id) . '/Versions/' . rawurlencode($schemaVersion) . '';
    }

    public function fetch(): VersionInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new VersionInstance($this->version, $payload, $this->solution['id'], $this->solution['schemaVersion']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Events.V1.VersionContext ' . implode(' ', $context) . ']';
    }
}