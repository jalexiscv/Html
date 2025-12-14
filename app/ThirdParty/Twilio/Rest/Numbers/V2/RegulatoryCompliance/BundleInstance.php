<?php

namespace Twilio\Rest\Numbers\V2\RegulatoryCompliance;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Numbers\V2\RegulatoryCompliance\Bundle\EvaluationList;
use Twilio\Rest\Numbers\V2\RegulatoryCompliance\Bundle\ItemAssignmentList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class BundleInstance extends InstanceResource
{
    protected $_evaluations;
    protected $_itemAssignments;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'regulationSid' => Values::array_get($payload, 'regulation_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'status' => Values::array_get($payload, 'status'), 'validUntil' => Deserialize::dateTime(Values::array_get($payload, 'valid_until')), 'email' => Values::array_get($payload, 'email'), 'statusCallback' => Values::array_get($payload, 'status_callback'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): BundleContext
    {
        if (!$this->context) {
            $this->context = new BundleContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): BundleInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): BundleInstance
    {
        return $this->proxy()->update($options);
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    protected function getEvaluations(): EvaluationList
    {
        return $this->proxy()->evaluations;
    }

    protected function getItemAssignments(): ItemAssignmentList
    {
        return $this->proxy()->itemAssignments;
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
        return '[Twilio.Numbers.V2.BundleInstance ' . implode(' ', $context) . ']';
    }
}