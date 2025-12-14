<?php

namespace Twilio\Rest\Api\V2010\Account\Sip\IpAccessControlList;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;
use function rawurlencode;

class IpAddressList extends ListResource
{
    public function __construct(Version $version, string $accountSid, string $ipAccessControlListSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'ipAccessControlListSid' => $ipAccessControlListSid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/SIP/IpAccessControlLists/' . rawurlencode($ipAccessControlListSid) . '/IpAddresses.json';
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

    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): IpAddressPage
    {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new IpAddressPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): IpAddressPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new IpAddressPage($this->version, $response, $this->solution);
    }

    public function create(string $friendlyName, string $ipAddress, array $options = []): IpAddressInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $friendlyName, 'IpAddress' => $ipAddress, 'CidrPrefixLength' => $options['cidrPrefixLength'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new IpAddressInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['ipAccessControlListSid']);
    }

    public function getContext(string $sid): IpAddressContext
    {
        return new IpAddressContext($this->version, $this->solution['accountSid'], $this->solution['ipAccessControlListSid'], $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Api.V2010.IpAddressList]';
    }
}