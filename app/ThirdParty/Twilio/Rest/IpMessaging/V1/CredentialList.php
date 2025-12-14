<?php

namespace Twilio\Rest\IpMessaging\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class CredentialList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/Credentials';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): CredentialPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new CredentialPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): CredentialPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new CredentialPage($this->version, $response, $this->solution);
    }

    public function create(string $type, array $options = []): CredentialInstance
    {
        $options = new Values($options);
        $data = Values::of(['Type' => $type, 'FriendlyName' => $options['friendlyName'], 'Certificate' => $options['certificate'], 'PrivateKey' => $options['privateKey'], 'Sandbox' => Serialize::booleanToString($options['sandbox']), 'ApiKey' => $options['apiKey'], 'Secret' => $options['secret'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new CredentialInstance($this->version, $payload);
    }

    public function getContext(string $sid): CredentialContext
    {
        return new CredentialContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.IpMessaging.V1.CredentialList]';
    }
}