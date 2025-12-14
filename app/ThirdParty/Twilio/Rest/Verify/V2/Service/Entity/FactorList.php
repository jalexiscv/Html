<?php

namespace Twilio\Rest\Verify\V2\Service\Entity;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class FactorList extends ListResource
{
    public function __construct(Version $version, string $serviceSid, string $identity)
    {
        parent::__construct($version);
        $this->solution = ['serviceSid' => $serviceSid, 'identity' => $identity,];
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Entities/' . rawurlencode($identity) . '/Factors';
    }

    public function create(string $friendlyName, string $factorType, array $options = []): FactorInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $friendlyName, 'FactorType' => $factorType, 'Binding.Alg' => $options['bindingAlg'], 'Binding.PublicKey' => $options['bindingPublicKey'], 'Config.AppId' => $options['configAppId'], 'Config.NotificationPlatform' => $options['configNotificationPlatform'], 'Config.NotificationToken' => $options['configNotificationToken'], 'Config.SdkVersion' => $options['configSdkVersion'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new FactorInstance($this->version, $payload, $this->solution['serviceSid'], $this->solution['identity']);
    }

    public function stream(int $limit = null, $pageSize = null): Stream
    {
        $limits = $this->version->readLimits($limit, $pageSize);
        $page = $this->page($limits['pageSize']);
        return $this->version->stream($page, $limits['limit'], $limits['pageLimit']);
    }

    public function read(int $limit = null, $pageSize = null): array
    {
        return iterator_to_array($this->stream($limit, $pageSize), false);
    }

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): FactorPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new FactorPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): FactorPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new FactorPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): FactorContext
    {
        return new FactorContext($this->version, $this->solution['serviceSid'], $this->solution['identity'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Verify.V2.FactorList]';
    }
}