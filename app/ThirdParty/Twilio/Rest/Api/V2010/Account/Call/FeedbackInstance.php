<?php

namespace Twilio\Rest\Api\V2010\Account\Call;

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

class FeedbackInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $accountSid, string $callSid)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'issues' => Values::array_get($payload, 'issues'), 'qualityScore' => Values::array_get($payload, 'quality_score'), 'sid' => Values::array_get($payload, 'sid'),];
        $this->solution = ['accountSid' => $accountSid, 'callSid' => $callSid,];
    }

    protected function proxy(): FeedbackContext
    {
        if (!$this->context) {
            $this->context = new FeedbackContext($this->version, $this->solution['accountSid'], $this->solution['callSid']);
        }
        return $this->context;
    }

    public function create(int $qualityScore, array $options = []): FeedbackInstance
    {
        return $this->proxy()->create($qualityScore, $options);
    }

    public function fetch(): FeedbackInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(int $qualityScore, array $options = []): FeedbackInstance
    {
        return $this->proxy()->update($qualityScore, $options);
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
        return '[Twilio.Api.V2010.FeedbackInstance ' . implode(' ', $context) . ']';
    }
}