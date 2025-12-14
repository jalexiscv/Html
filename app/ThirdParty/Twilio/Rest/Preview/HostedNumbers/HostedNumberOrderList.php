<?php

namespace Twilio\Rest\Preview\HostedNumbers;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use function iterator_to_array;

class HostedNumberOrderList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/HostedNumberOrders';
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

    public function page(array $options = [], $pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): HostedNumberOrderPage
    {
        $options = new Values($options);
        $params = Values::of(['Status' => $options['status'], 'PhoneNumber' => $options['phoneNumber'], 'IncomingPhoneNumberSid' => $options['incomingPhoneNumberSid'], 'FriendlyName' => $options['friendlyName'], 'UniqueName' => $options['uniqueName'], 'PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize,]);
        $response = $this->version->page('GET', $this->uri, $params);
        return new HostedNumberOrderPage($this->version, $response, $this->solution);
    }

    public function getPage(string $targetUrl): HostedNumberOrderPage
    {
        $response = $this->version->getDomain()->getClient()->request('GET', $targetUrl);
        return new HostedNumberOrderPage($this->version, $response, $this->solution);
    }

    public function create(string $phoneNumber, bool $smsCapability, array $options = []): HostedNumberOrderInstance
    {
        $options = new Values($options);
        $data = Values::of(['PhoneNumber' => $phoneNumber, 'SmsCapability' => Serialize::booleanToString($smsCapability), 'AccountSid' => $options['accountSid'], 'FriendlyName' => $options['friendlyName'], 'UniqueName' => $options['uniqueName'], 'CcEmails' => Serialize::map($options['ccEmails'], function ($e) {
            return $e;
        }), 'SmsUrl' => $options['smsUrl'], 'SmsMethod' => $options['smsMethod'], 'SmsFallbackUrl' => $options['smsFallbackUrl'], 'SmsFallbackMethod' => $options['smsFallbackMethod'], 'StatusCallbackUrl' => $options['statusCallbackUrl'], 'StatusCallbackMethod' => $options['statusCallbackMethod'], 'SmsApplicationSid' => $options['smsApplicationSid'], 'AddressSid' => $options['addressSid'], 'Email' => $options['email'], 'VerificationType' => $options['verificationType'], 'VerificationDocumentSid' => $options['verificationDocumentSid'],]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new HostedNumberOrderInstance($this->version, $payload);
    }

    public function getContext(string $sid): HostedNumberOrderContext
    {
        return new HostedNumberOrderContext($this->version, $sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Preview.HostedNumbers.HostedNumberOrderList]';
    }
}