<?php

namespace Twilio\Rest\Video\V1;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class CompositionInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'status' => Values::array_get($payload, 'status'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateCompleted' => Deserialize::dateTime(Values::array_get($payload, 'date_completed')), 'dateDeleted' => Deserialize::dateTime(Values::array_get($payload, 'date_deleted')), 'sid' => Values::array_get($payload, 'sid'), 'roomSid' => Values::array_get($payload, 'room_sid'), 'audioSources' => Values::array_get($payload, 'audio_sources'), 'audioSourcesExcluded' => Values::array_get($payload, 'audio_sources_excluded'), 'videoLayout' => Values::array_get($payload, 'video_layout'), 'resolution' => Values::array_get($payload, 'resolution'), 'trim' => Values::array_get($payload, 'trim'), 'format' => Values::array_get($payload, 'format'), 'bitrate' => Values::array_get($payload, 'bitrate'), 'size' => Values::array_get($payload, 'size'), 'duration' => Values::array_get($payload, 'duration'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): CompositionContext
    {
        if (!$this->context) {
            $this->context = new CompositionContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): CompositionInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function __get(string $name)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown property: ' . $name);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Video.V1.CompositionInstance ' . implode(' ', $context) . ']';
    }
}