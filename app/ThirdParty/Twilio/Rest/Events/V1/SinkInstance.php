<?php

namespace Twilio\Rest\Events\V1;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Rest\Events\V1\Sink\SinkTestList;
use Twilio\Rest\Events\V1\Sink\SinkValidateList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class SinkInstance extends InstanceResource
{
    protected $_sinkTest;
    protected $_sinkValidate;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'description' => Values::array_get($payload, 'description'), 'sid' => Values::array_get($payload, 'sid'), 'sinkConfiguration' => Values::array_get($payload, 'sink_configuration'), 'sinkType' => Values::array_get($payload, 'sink_type'), 'status' => Values::array_get($payload, 'status'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): SinkContext
    {
        if (!$this->context) {
            $this->context = new SinkContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): SinkInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    protected function getSinkTest(): SinkTestList
    {
        return $this->proxy()->sinkTest;
    }

    protected function getSinkValidate(): SinkValidateList
    {
        return $this->proxy()->sinkValidate;
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
        return '[Twilio.Events.V1.SinkInstance ' . implode(' ', $context) . ']';
    }
}