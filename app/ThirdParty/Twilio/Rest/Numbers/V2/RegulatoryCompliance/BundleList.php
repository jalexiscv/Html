<?php

namespace Twilio\Rest\Numbers\V2\RegulatoryCompliance;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class BundleList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/RegulatoryCompliance/Bundles';
    }

    public function create(string $friendlyName, string $email, array $options = []): BundleInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $friendlyName, 'Email' => $email, 'StatusCallback' => $options['statusCallback'], 'RegulationSid' => $options['regulationSid'], 'IsoCountry' => $options['isoCountry'], 'EndUserType' => $options['endUserType'], 'NumberType' => $options['numberType'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new BundleInstance($this->version, $payload);
    }

    public function stream(array $options = [], int $limit = null, $pageSize = null): Stream
    {
        $limits = $this->version->readLimits($limit, $pageSize);
        $page = $this->page($options, $limits['pageSize']);
        return $this->version->stream($page, $limits['limit'], $limits['pageLimit']);
    }

    public function read(array $options = [], int $limit = null, $pageSize = null): array
    {
        return iterator_to_array($this->stream($options, $limit, $pageSize), false);
    }

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): BundlePage
    {
        $options = new Values($options);
        $params = Values::of(['Status' => $options['status'], 'FriendlyName' => $options['friendlyName'], 'RegulationSid' => $options['regulationSid'], 'IsoCountry' => $options['isoCountry'], 'NumberType' => $options['numberType'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new BundlePage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): BundlePage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new BundlePage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): BundleContext
    {
        return new BundleContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Numbers.V2.BundleList]';
    }
}