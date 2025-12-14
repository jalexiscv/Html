<?php

namespace Twilio\Rest\Numbers\V2\RegulatoryCompliance;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Numbers\V2\RegulatoryCompliance\Bundle\EvaluationContext;
use Twilio\Rest\Numbers\V2\RegulatoryCompliance\Bundle\EvaluationList;
use Twilio\Rest\Numbers\V2\RegulatoryCompliance\Bundle\ItemAssignmentContext;
use Twilio\Rest\Numbers\V2\RegulatoryCompliance\Bundle\ItemAssignmentList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class BundleContext extends InstanceContext
{
    protected $_evaluations;
    protected $_itemAssignments;

    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/RegulatoryCompliance/Bundles/' . rawurlencode($sid) . '';
    }

    public function fetch(): BundleInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new BundleInstance($this->version, $payload, $this->solution['sid']);
    }

    public function update(array $options = []): BundleInstance
    {
        $options = new Values($options);
        $data = Values::of(['Status' => $options['status'], 'StatusCallback' => $options['statusCallback'], 'FriendlyName' => $options['friendlyName'], 'Email' => $options['email'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new BundleInstance($this->version, $payload, $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    protected function getEvaluations(): EvaluationList
    {
        if (!$this->_evaluations) {
            $this->_evaluations = new EvaluationList($this->version, $this->solution['sid']);
        }
        return $this->_evaluations;
    }

    protected function getItemAssignments(): ItemAssignmentList
    {
        if (!$this->_itemAssignments) {
            $this->_itemAssignments = new ItemAssignmentList($this->version, $this->solution['sid']);
        }
        return $this->_itemAssignments;
    }

    public function __get(string $name): ListResource
    {
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown subresource ' . $name);
    }

    public function __call(string $name, array $arguments): InstanceContext
    {
        $property = $this->$name;
        if (method_exists($property, 'getContext')) {
            return call_user_func_array(array($property, 'getContext'), $arguments);
        }
        throw new TwilioException('Resource does not have a context');
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Numbers.V2.BundleContext ' . implode(' ', $context) . ']';
    }
}