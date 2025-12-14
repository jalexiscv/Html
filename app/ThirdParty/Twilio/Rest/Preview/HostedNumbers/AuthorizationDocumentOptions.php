<?php

namespace Twilio\Rest\Preview\HostedNumbers;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class AuthorizationDocumentOptions
{
    public static function update(array $hostedNumberOrderSids = Values::ARRAY_NONE, string $addressSid = Values::NONE, string $email = Values::NONE, array $ccEmails = Values::ARRAY_NONE, string $status = Values::NONE, string $contactTitle = Values::NONE, string $contactPhoneNumber = Values::NONE): UpdateAuthorizationDocumentOptions
    {
        return new UpdateAuthorizationDocumentOptions($hostedNumberOrderSids, $addressSid, $email, $ccEmails, $status, $contactTitle, $contactPhoneNumber);
    }

    public static function read(string $email = Values::NONE, string $status = Values::NONE): ReadAuthorizationDocumentOptions
    {
        return new ReadAuthorizationDocumentOptions($email, $status);
    }

    public static function create(array $ccEmails = Values::ARRAY_NONE): CreateAuthorizationDocumentOptions
    {
        return new CreateAuthorizationDocumentOptions($ccEmails);
    }
}

class UpdateAuthorizationDocumentOptions extends Options
{
    public function __construct(array $hostedNumberOrderSids = Values::ARRAY_NONE, string $addressSid = Values::NONE, string $email = Values::NONE, array $ccEmails = Values::ARRAY_NONE, string $status = Values::NONE, string $contactTitle = Values::NONE, string $contactPhoneNumber = Values::NONE)
    {
        $this->options['hostedNumberOrderSids'] = $hostedNumberOrderSids;
        $this->options['addressSid'] = $addressSid;
        $this->options['email'] = $email;
        $this->options['ccEmails'] = $ccEmails;
        $this->options['status'] = $status;
        $this->options['contactTitle'] = $contactTitle;
        $this->options['contactPhoneNumber'] = $contactPhoneNumber;
    }

    public function setHostedNumberOrderSids(array $hostedNumberOrderSids): self
    {
        $this->options['hostedNumberOrderSids'] = $hostedNumberOrderSids;
        return $this;
    }

    public function setAddressSid(string $addressSid): self
    {
        $this->options['addressSid'] = $addressSid;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->options['email'] = $email;
        return $this;
    }

    public function setCcEmails(array $ccEmails): self
    {
        $this->options['ccEmails'] = $ccEmails;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function setContactTitle(string $contactTitle): self
    {
        $this->options['contactTitle'] = $contactTitle;
        return $this;
    }

    public function setContactPhoneNumber(string $contactPhoneNumber): self
    {
        $this->options['contactPhoneNumber'] = $contactPhoneNumber;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.HostedNumbers.UpdateAuthorizationDocumentOptions ' . $options . ']';
    }
}

class ReadAuthorizationDocumentOptions extends Options
{
    public function __construct(string $email = Values::NONE, string $status = Values::NONE)
    {
        $this->options['email'] = $email;
        $this->options['status'] = $status;
    }

    public function setEmail(string $email): self
    {
        $this->options['email'] = $email;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.HostedNumbers.ReadAuthorizationDocumentOptions ' . $options . ']';
    }
}

class CreateAuthorizationDocumentOptions extends Options
{
    public function __construct(array $ccEmails = Values::ARRAY_NONE)
    {
        $this->options['ccEmails'] = $ccEmails;
    }

    public function setCcEmails(array $ccEmails): self
    {
        $this->options['ccEmails'] = $ccEmails;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.HostedNumbers.CreateAuthorizationDocumentOptions ' . $options . ']';
    }
}