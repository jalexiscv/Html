<?php

namespace Twilio\Rest;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Rest\Preview\BulkExports as PreviewBulkExports;
use Twilio\Rest\Preview\BulkExports\ExportConfigurationContext;
use Twilio\Rest\Preview\BulkExports\ExportConfigurationList;
use Twilio\Rest\Preview\BulkExports\ExportContext;
use Twilio\Rest\Preview\BulkExports\ExportList;
use Twilio\Rest\Preview\DeployedDevices as PreviewDeployedDevices;
use Twilio\Rest\Preview\DeployedDevices\FleetContext;
use Twilio\Rest\Preview\DeployedDevices\FleetList;
use Twilio\Rest\Preview\HostedNumbers as PreviewHostedNumbers;
use Twilio\Rest\Preview\HostedNumbers\AuthorizationDocumentContext;
use Twilio\Rest\Preview\HostedNumbers\AuthorizationDocumentList;
use Twilio\Rest\Preview\HostedNumbers\HostedNumberOrderContext;
use Twilio\Rest\Preview\HostedNumbers\HostedNumberOrderList;
use Twilio\Rest\Preview\Marketplace as PreviewMarketplace;
use Twilio\Rest\Preview\Marketplace\AvailableAddOnContext;
use Twilio\Rest\Preview\Marketplace\AvailableAddOnList;
use Twilio\Rest\Preview\Marketplace\InstalledAddOnContext;
use Twilio\Rest\Preview\Marketplace\InstalledAddOnList;
use Twilio\Rest\Preview\Sync as PreviewSync;
use Twilio\Rest\Preview\Sync\ServiceContext;
use Twilio\Rest\Preview\Sync\ServiceList;
use Twilio\Rest\Preview\TrustedComms as PreviewTrustedComms;
use Twilio\Rest\Preview\TrustedComms\BrandedChannelContext;
use Twilio\Rest\Preview\TrustedComms\BrandedChannelList;
use Twilio\Rest\Preview\TrustedComms\BrandsInformationContext;
use Twilio\Rest\Preview\TrustedComms\BrandsInformationList;
use Twilio\Rest\Preview\TrustedComms\CpsContext;
use Twilio\Rest\Preview\TrustedComms\CpsList;
use Twilio\Rest\Preview\TrustedComms\CurrentCallContext;
use Twilio\Rest\Preview\TrustedComms\CurrentCallList;
use Twilio\Rest\Preview\Understand as PreviewUnderstand;
use Twilio\Rest\Preview\Understand\AssistantContext;
use Twilio\Rest\Preview\Understand\AssistantList;
use Twilio\Rest\Preview\Wireless as PreviewWireless;
use Twilio\Rest\Preview\Wireless\CommandContext;
use Twilio\Rest\Preview\Wireless\CommandList;
use Twilio\Rest\Preview\Wireless\RatePlanContext;
use Twilio\Rest\Preview\Wireless\RatePlanList;
use Twilio\Rest\Preview\Wireless\SimContext;
use Twilio\Rest\Preview\Wireless\SimList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class Preview extends Domain
{
    protected $_bulkExports;
    protected $_deployedDevices;
    protected $_hostedNumbers;
    protected $_marketplace;
    protected $_sync;
    protected $_understand;
    protected $_wireless;
    protected $_trustedComms;

    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->baseUrl = 'https://preview.twilio.com';
    }

    protected function getBulkExports(): PreviewBulkExports
    {
        if (!$this->_bulkExports) {
            $this->_bulkExports = new PreviewBulkExports($this);
        }
        return $this->_bulkExports;
    }

    protected function getDeployedDevices(): PreviewDeployedDevices
    {
        if (!$this->_deployedDevices) {
            $this->_deployedDevices = new PreviewDeployedDevices($this);
        }
        return $this->_deployedDevices;
    }

    protected function getHostedNumbers(): PreviewHostedNumbers
    {
        if (!$this->_hostedNumbers) {
            $this->_hostedNumbers = new PreviewHostedNumbers($this);
        }
        return $this->_hostedNumbers;
    }

    protected function getMarketplace(): PreviewMarketplace
    {
        if (!$this->_marketplace) {
            $this->_marketplace = new PreviewMarketplace($this);
        }
        return $this->_marketplace;
    }

    protected function getSync(): PreviewSync
    {
        if (!$this->_sync) {
            $this->_sync = new PreviewSync($this);
        }
        return $this->_sync;
    }

    protected function getUnderstand(): PreviewUnderstand
    {
        if (!$this->_understand) {
            $this->_understand = new PreviewUnderstand($this);
        }
        return $this->_understand;
    }

    protected function getWireless(): PreviewWireless
    {
        if (!$this->_wireless) {
            $this->_wireless = new PreviewWireless($this);
        }
        return $this->_wireless;
    }

    protected function getTrustedComms(): PreviewTrustedComms
    {
        if (!$this->_trustedComms) {
            $this->_trustedComms = new PreviewTrustedComms($this);
        }
        return $this->_trustedComms;
    }

    public function __get(string $name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        throw new TwilioException('Unknown version ' . $name);
    }

    public function __call(string $name, array $arguments)
    {
        $method = 'context' . ucfirst($name);
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $arguments);
        }
        throw new TwilioException('Unknown context ' . $name);
    }

    protected function getExports(): ExportList
    {
        return $this->bulkExports->exports;
    }

    protected function contextExports(string $resourceType): ExportContext
    {
        return $this->bulkExports->exports($resourceType);
    }

    protected function getExportConfiguration(): ExportConfigurationList
    {
        return $this->bulkExports->exportConfiguration;
    }

    protected function contextExportConfiguration(string $resourceType): ExportConfigurationContext
    {
        return $this->bulkExports->exportConfiguration($resourceType);
    }

    protected function getFleets(): FleetList
    {
        return $this->deployedDevices->fleets;
    }

    protected function contextFleets(string $sid): FleetContext
    {
        return $this->deployedDevices->fleets($sid);
    }

    protected function getAuthorizationDocuments(): AuthorizationDocumentList
    {
        return $this->hostedNumbers->authorizationDocuments;
    }

    protected function contextAuthorizationDocuments(string $sid): AuthorizationDocumentContext
    {
        return $this->hostedNumbers->authorizationDocuments($sid);
    }

    protected function getHostedNumberOrders(): HostedNumberOrderList
    {
        return $this->hostedNumbers->hostedNumberOrders;
    }

    protected function contextHostedNumberOrders(string $sid): HostedNumberOrderContext
    {
        return $this->hostedNumbers->hostedNumberOrders($sid);
    }

    protected function getAvailableAddOns(): AvailableAddOnList
    {
        return $this->marketplace->availableAddOns;
    }

    protected function contextAvailableAddOns(string $sid): AvailableAddOnContext
    {
        return $this->marketplace->availableAddOns($sid);
    }

    protected function getInstalledAddOns(): InstalledAddOnList
    {
        return $this->marketplace->installedAddOns;
    }

    protected function contextInstalledAddOns(string $sid): InstalledAddOnContext
    {
        return $this->marketplace->installedAddOns($sid);
    }

    protected function getServices(): ServiceList
    {
        return $this->sync->services;
    }

    protected function contextServices(string $sid): ServiceContext
    {
        return $this->sync->services($sid);
    }

    protected function getAssistants(): AssistantList
    {
        return $this->understand->assistants;
    }

    protected function contextAssistants(string $sid): AssistantContext
    {
        return $this->understand->assistants($sid);
    }

    protected function getCommands(): CommandList
    {
        return $this->wireless->commands;
    }

    protected function contextCommands(string $sid): CommandContext
    {
        return $this->wireless->commands($sid);
    }

    protected function getRatePlans(): RatePlanList
    {
        return $this->wireless->ratePlans;
    }

    protected function contextRatePlans(string $sid): RatePlanContext
    {
        return $this->wireless->ratePlans($sid);
    }

    protected function getSims(): SimList
    {
        return $this->wireless->sims;
    }

    protected function contextSims(string $sid): SimContext
    {
        return $this->wireless->sims($sid);
    }

    protected function getBrandedChannels(): BrandedChannelList
    {
        return $this->trustedComms->brandedChannels;
    }

    protected function contextBrandedChannels(string $sid): BrandedChannelContext
    {
        return $this->trustedComms->brandedChannels($sid);
    }

    protected function getBrandsInformation(): BrandsInformationList
    {
        return $this->trustedComms->brandsInformation;
    }

    protected function contextBrandsInformation(): BrandsInformationContext
    {
        return $this->trustedComms->brandsInformation();
    }

    protected function getCps(): CpsList
    {
        return $this->trustedComms->cps;
    }

    protected function contextCps(): CpsContext
    {
        return $this->trustedComms->cps();
    }

    protected function getCurrentCalls(): CurrentCallList
    {
        return $this->trustedComms->currentCalls;
    }

    protected function contextCurrentCalls(): CurrentCallContext
    {
        return $this->trustedComms->currentCalls();
    }

    public function __toString(): string
    {
        return '[Twilio.Preview]';
    }
}