<?php

namespace Twilio\Rest\Video\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function implode;
use function rawurlencode;

class CompositionHookContext extends InstanceContext
{
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/CompositionHooks/' . rawurlencode($sid) . '';
    }

    public function fetch(): CompositionHookInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new CompositionHookInstance($this->version, $payload, $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function update(string $friendlyName, array $options = []): CompositionHookInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $friendlyName, 'Enabled' => Serialize::booleanToString($options['enabled']), 'VideoLayout' => Serialize::jsonObject($options['videoLayout']), 'AudioSources' => Serialize::map($options['audioSources'], function ($e) {
            return $e;
        }), 'AudioSourcesExcluded' => Serialize::map($options['audioSourcesExcluded'], function ($e) {
            return $e;
        }), 'Trim' => Serialize::booleanToString($options['trim']), 'Format' => $options['format'], 'Resolution' => $options['resolution'], 'StatusCallback' => $options['statusCallback'], 'StatusCallbackMethod' => $options['statusCallbackMethod'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new CompositionHookInstance($this->version, $payload, $this->solution['sid']);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Video.V1.CompositionHookContext ' . implode(' ', $context) . ']';
    }
}