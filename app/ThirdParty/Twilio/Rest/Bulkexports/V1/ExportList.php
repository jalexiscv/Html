<?php

namespace Twilio\Rest\Bulkexports\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Bulkexports\V1\Export\JobContext;
use Twilio\Rest\Bulkexports\V1\Export\JobList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function property_exists;
use function ucfirst;

class ExportList extends ListResource
{
    protected $_jobs = null;

    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
    }

    protected function getJobs(): JobList
    {
        if (!$this->_jobs) {
            $this->_jobs = new JobList($this->version);
        }
        return $this->_jobs;
    }

    public function getContext(string $resourceType): ExportContext
    {
        return new ExportContext($this->version, $resourceType);
    }

    public function __get(string $name)
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
        return '[Twilio.Bulkexports.V1.ExportList]';
    }
}