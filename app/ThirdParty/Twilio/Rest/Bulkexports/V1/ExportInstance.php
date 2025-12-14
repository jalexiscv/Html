<?php

namespace Twilio\Rest\Bulkexports\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Rest\Bulkexports\V1\Export\DayList;
use Twilio\Rest\Bulkexports\V1\Export\ExportCustomJobList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ExportInstance extends InstanceResource
{
    protected $_days;
    protected $_exportCustomJobs;

    public function __construct(Version $version, array $payload, string $resourceType = null)
    {
        parent::__construct($version);
        $this->properties = ['resourceType' => Values::array_get($payload, 'resource_type'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['resourceType' => $resourceType ?: $this->properties['resourceType'],];
    }

    protected function proxy(): ExportContext
    {
        if (!$this->context) {
            $this->context = new ExportContext($this->version, $this->solution['resourceType']);
        }
        return $this->context;
    }

    public function fetch(): ExportInstance
    {
        return $this->proxy()->fetch();
    }

    protected function getDays(): DayList
    {
        return $this->proxy()->days;
    }

    protected function getExportCustomJobs(): ExportCustomJobList
    {
        return $this->proxy()->exportCustomJobs;
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
        return '[Twilio.Bulkexports.V1.ExportInstance ' . implode(' ', $context) . ']';
    }
}