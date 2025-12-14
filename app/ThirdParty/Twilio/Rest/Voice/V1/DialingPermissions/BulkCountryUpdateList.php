<?php

namespace Twilio\Rest\Voice\V1\DialingPermissions;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Values;
use Twilio\Version;

class BulkCountryUpdateList extends ListResource
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->solution = [];
        $this->uri = '/DialingPermissions/BulkCountryUpdates';
    }

    public function create(string $updateRequest): BulkCountryUpdateInstance
    {
        $data = Values::of(['UpdateRequest' => $updateRequest,]);
        $payload = $this->version->create('POST', $this->uri, [], $data);
        return new BulkCountryUpdateInstance($this->version, $payload);
    }

    public function __toString(): string
    {
        return '[Twilio.Voice.V1.BulkCountryUpdateList]';
    }
}