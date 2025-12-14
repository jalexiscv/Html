<?php

namespace Twilio\Rest\Trunking\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class TrunkList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Trunks';
    }

    public function create(array $options = []): TrunkInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'DomainName' => $options['domainName'], 'DisasterRecoveryUrl' => $options['disasterRecoveryUrl'], 'DisasterRecoveryMethod' => $options['disasterRecoveryMethod'], 'TransferMode' => $options['transferMode'], 'Secure' => Serialize::booleanToString($options['secure']), 'CnamLookupEnabled' => Serialize::booleanToString($options['cnamLookupEnabled']),]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new TrunkInstance($this->version, $payload);
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): TrunkPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new TrunkPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): TrunkPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new TrunkPage($this->version, $response, $this->solution);
    }

    public function getContext(string $sid): TrunkContext
    {
        return new TrunkContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Trunking.V1.TrunkList]';
    }
}