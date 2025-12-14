<?php

namespace Twilio\Rest\Preview\Marketplace;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class InstalledAddOnList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/InstalledAddOns';
    }

    public function create(string $availableAddOnSid, bool $acceptTermsOfService, array $options = []): InstalledAddOnInstance
    {
        $options = new Values($options);
        $data = Values::of(['AvailableAddOnSid' => $availableAddOnSid, 'AcceptTermsOfService' => Serialize::booleanToString($acceptTermsOfService), 'Configuration' => Serialize::jsonObject($options['configuration']), 'UniqueName' => $options['uniqueName'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new InstalledAddOnInstance($this->version, $payload);
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): InstalledAddOnPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new InstalledAddOnPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): InstalledAddOnPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new InstalledAddOnPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): InstalledAddOnContext
    {
        return new InstalledAddOnContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.Marketplace.InstalledAddOnList]';
    }
}