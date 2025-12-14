<?php

namespace Twilio\Rest\Preview;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Preview\BulkExports\ExportConfigurationContext;
use Twilio\Rest\Preview\BulkExports\ExportConfigurationList;
use Twilio\Rest\Preview\BulkExports\ExportContext;
use Twilio\Rest\Preview\BulkExports\ExportList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class BulkExports extends Version
{
    protected $_exports;
    protected $_exportConfiguration;

    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
        $this->version = 'BulkExports';
    }

    protected function getExports(): ExportList
    {
        if (!$this->_exports) {
            $this->_exports = new ExportList($this);
        }
        return $this->_exports;
    }

    protected function getExportConfiguration(): ExportConfigurationList
    {
        if (!$this->_exportConfiguration) {
            $this->_exportConfiguration = new ExportConfigurationList($this);
        }
        return $this->_exportConfiguration;
    }

    public function __get(string $name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        throw new TwilioException('Unknown resource ' . $name);
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
        return '[Twilio.Preview.BulkExports]';
    }
}