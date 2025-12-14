<?php

namespace Twilio\Rest\Numbers\V2;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Numbers\V2\RegulatoryCompliance\BundleContext;
use Twilio\Rest\Numbers\V2\RegulatoryCompliance\BundleList;
use Twilio\Rest\Numbers\V2\RegulatoryCompliance\EndUserContext;
use Twilio\Rest\Numbers\V2\RegulatoryCompliance\EndUserList;
use Twilio\Rest\Numbers\V2\RegulatoryCompliance\EndUserTypeContext;
use Twilio\Rest\Numbers\V2\RegulatoryCompliance\EndUserTypeList;
use Twilio\Rest\Numbers\V2\RegulatoryCompliance\RegulationContext;
use Twilio\Rest\Numbers\V2\RegulatoryCompliance\RegulationList;
use Twilio\Rest\Numbers\V2\RegulatoryCompliance\SupportingDocumentContext;
use Twilio\Rest\Numbers\V2\RegulatoryCompliance\SupportingDocumentList;
use Twilio\Rest\Numbers\V2\RegulatoryCompliance\SupportingDocumentTypeContext;
use Twilio\Rest\Numbers\V2\RegulatoryCompliance\SupportingDocumentTypeList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function property_exists;
use function ucfirst;

class RegulatoryComplianceList extends ListResource
{
    protected $_bundles = null;
    protected $_endUsers = null;
    protected $_endUserTypes = null;
    protected $_regulations = null;
    protected $_supportingDocuments = null;
    protected $_supportingDocumentTypes = null;

    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
    }

    protected function getBundles(): BundleList
    {
        if (!$this->_bundles) {
            $this->_bundles = new BundleList($this->version);
        }
        return $this->_bundles;
    }

    protected function getEndUsers(): EndUserList
    {
        if (!$this->_endUsers) {
            $this->_endUsers = new EndUserList($this->version);
        }
        return $this->_endUsers;
    }

    protected function getEndUserTypes(): EndUserTypeList
    {
        if (!$this->_endUserTypes) {
            $this->_endUserTypes = new EndUserTypeList($this->version);
        }
        return $this->_endUserTypes;
    }

    protected function getRegulations(): RegulationList
    {
        if (!$this->_regulations) {
            $this->_regulations = new RegulationList($this->version);
        }
        return $this->_regulations;
    }

    protected function getSupportingDocuments(): SupportingDocumentList
    {
        if (!$this->_supportingDocuments) {
            $this->_supportingDocuments = new SupportingDocumentList($this->version);
        }
        return $this->_supportingDocuments;
    }

    protected function getSupportingDocumentTypes(): SupportingDocumentTypeList
    {
        if (!$this->_supportingDocumentTypes) {
            $this->_supportingDocumentTypes = new SupportingDocumentTypeList($this->version);
        }
        return $this->_supportingDocumentTypes;
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
        return '[Twilio.Numbers.V2.RegulatoryComplianceList]';
    }
}