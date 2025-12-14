<?php

namespace Twilio\Rest\Video\V1;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class CompositionHookInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'enabled' => Values::array_get($payload, 'enabled'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'sid' => Values::array_get($payload, 'sid'), 'audioSources' => Values::array_get($payload, 'audio_sources'), 'audioSourcesExcluded' => Values::array_get($payload, 'audio_sources_excluded'), 'videoLayout' => Values::array_get($payload, 'video_layout'), 'resolution' => Values::array_get($payload, 'resolution'), 'trim' => Values::array_get($payload, 'trim'), 'format' => Values::array_get($payload, 'format'), 'statusCallback' => Values::array_get($payload, 'status_callback'), 'statusCallbackMethod' => Values::array_get($payload, 'status_callback_method'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): CompositionHookContext
    {
        if (!$this->context) {
            $this->context = new CompositionHookContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): CompositionHookInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function update(string $friendlyName, array $options = []): CompositionHookInstance
    {
        return $this->proxy()->update($friendlyName, $options);
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
        return '[Twilio.Video.V1.CompositionHookInstance ' . implode(' ', $context) . ']';
    }
}