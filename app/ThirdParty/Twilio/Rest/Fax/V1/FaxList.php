<?php

namespace Twilio\Rest\Fax\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class FaxList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Faxes';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): FaxPage
    {
        $options = new Values($options);
        $params = Values::of(['From' => $options['from'], 'To' => $options['to'], 'DateCreatedOnOrBefore' => Serialize::iso8601DateTime($options['dateCreatedOnOrBefore']), 'DateCreatedAfter' => Serialize::iso8601DateTime($options['dateCreatedAfter']), 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new FaxPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): FaxPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new FaxPage($this->version, $response, $this->solution);
    }

    public function create(string $to, string $mediaUrl, array $options = []): FaxInstance
    {
        $options = new Values($options);
        $data = Values::of(['To' => $to, 'MediaUrl' => $mediaUrl, 'Quality' => $options['quality'], 'StatusCallback' => $options['statusCallback'], 'From' => $options['from'], 'SipAuthUsername' => $options['sipAuthUsername'], 'SipAuthPassword' => $options['sipAuthPassword'], 'StoreMedia' => Serialize::booleanToString($options['storeMedia']), 'Ttl' => $options['ttl'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new FaxInstance($this->version, $payload);
    }

    public function getContext(string $sid): FaxContext
    {
        return new FaxContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Fax.V1.FaxList]';
    }
}