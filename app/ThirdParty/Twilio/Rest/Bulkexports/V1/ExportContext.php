<?php

namespace Twilio\Rest\Bulkexports\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Bulkexports\V1\Export\DayContext;
use Twilio\Rest\Bulkexports\V1\Export\DayList;
use Twilio\Rest\Bulkexports\V1\Export\ExportCustomJobList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class ExportContext extends InstanceContext
{
    protected $_days;
    protected $_exportCustomJobs;

    public function __construct(Version $version, $resourceType)
    {
        parent::__construct($version);
        $this->solution = ['resourceType' => $resourceType,];
        $this->uri = '/Exports/' . rawurlencode($resourceType) . '';
    }

    public function fetch(): ExportInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ExportInstance($this->version, $payload, $this->solution['resourceType']);
    }

    protected function getDays(): DayList
    {
        if (!$this->_days) {
            $this->_days = new DayList($this->version, $this->solution['resourceType']);
        }
        return $this->_days;
    }

    protected function getExportCustomJobs(): ExportCustomJobList
    {
        if (!$this->_exportCustomJobs) {
            $this->_exportCustomJobs = new ExportCustomJobList($this->version, $this->solution['resourceType']);
        }
        return $this->_exportCustomJobs;
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
        return '[Twilio.Bulkexports.V1.ExportContext ' . implode(' ', $context) . ']';
    }
}