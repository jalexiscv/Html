<?php

namespace Twilio\Rest\Preview\HostedNumbers;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class HostedNumberOrderOptions
{
    public static function update(string $friendlyName = Values::NONE, string $uniqueName = Values::NONE, string $email = Values::NONE, array $ccEmails = Values::ARRAY_NONE, string $status = Values::NONE, string $verificationCode = Values::NONE, string $verificationType = Values::NONE, string $verificationDocumentSid = Values::NONE, string $extension = Values::NONE, int $callDelay = Values::NONE): UpdateHostedNumberOrderOptions
    {
        return new UpdateHostedNumberOrderOptions($friendlyName, $uniqueName, $email, $ccEmails, $status, $verificationCode, $verificationType, $verificationDocumentSid, $extension, $callDelay);
    }

    public static function read(string $status = Values::NONE, string $phoneNumber = Values::NONE, string $incomingPhoneNumberSid = Values::NONE, string $friendlyName = Values::NONE, string $uniqueName = Values::NONE): ReadHostedNumberOrderOptions
    {
        return new ReadHostedNumberOrderOptions($status, $phoneNumber, $incomingPhoneNumberSid, $friendlyName, $uniqueName);
    }

    public static function create(string $accountSid = Values::NONE, string $friendlyName = Values::NONE, string $uniqueName = Values::NONE, array $ccEmails = Values::ARRAY_NONE, string $smsUrl = Values::NONE, string $smsMethod = Values::NONE, string $smsFallbackUrl = Values::NONE, string $smsFallbackMethod = Values::NONE, string $statusCallbackUrl = Values::NONE, string $statusCallbackMethod = Values::NONE, string $smsApplicationSid = Values::NONE, string $addressSid = Values::NONE, string $email = Values::NONE, string $verificationType = Values::NONE, string $verificationDocumentSid = Values::NONE): CreateHostedNumberOrderOptions
    {
        return new CreateHostedNumberOrderOptions($accountSid, $friendlyName, $uniqueName, $ccEmails, $smsUrl, $smsMethod, $smsFallbackUrl, $smsFallbackMethod, $statusCallbackUrl, $statusCallbackMethod, $smsApplicationSid, $addressSid, $email, $verificationType, $verificationDocumentSid);
    }
}

class UpdateHostedNumberOrderOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $uniqueName = Values::NONE, string $email = Values::NONE, array $ccEmails = Values::ARRAY_NONE, string $status = Values::NONE, string $verificationCode = Values::NONE, string $verificationType = Values::NONE, string $verificationDocumentSid = Values::NONE, string $extension = Values::NONE, int $callDelay = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['uniqueName'] = $uniqueName;
        $this->options['email'] = $email;
        $this->options['ccEmails'] = $ccEmails;
        $this->options['status'] = $status;
        $this->options['verificationCode'] = $verificationCode;
        $this->options['verificationType'] = $verificationType;
        $this->options['verificationDocumentSid'] = $verificationDocumentSid;
        $this->options['extension'] = $extension;
        $this->options['callDelay'] = $callDelay;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
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

    public function setVerificationCode(string $verificationCode): self
    {
        $this->options['verificationCode'] = $verificationCode;
        return $this;
    }

    public function setVerificationType(string $verificationType): self
    {
        $this->options['verificationType'] = $verificationType;
        return $this;
    }

    public function setVerificationDocumentSid(string $verificationDocumentSid): self
    {
        $this->options['verificationDocumentSid'] = $verificationDocumentSid;
        return $this;
    }

    public function setExtension(string $extension): self
    {
        $this->options['extension'] = $extension;
        return $this;
    }

    public function setCallDelay(int $callDelay): self
    {
        $this->options['callDelay'] = $callDelay;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.HostedNumbers.UpdateHostedNumberOrderOptions ' . $options . ']';
    }
}

class ReadHostedNumberOrderOptions extends Options
{
    public function __construct(string $status = Values::NONE, string $phoneNumber = Values::NONE, string $incomingPhoneNumberSid = Values::NONE, string $friendlyName = Values::NONE, string $uniqueName = Values::NONE)
    {
        $this->options['status'] = $status;
        $this->options['phoneNumber'] = $phoneNumber;
        $this->options['incomingPhoneNumberSid'] = $incomingPhoneNumberSid;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['uniqueName'] = $uniqueName;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->options['phoneNumber'] = $phoneNumber;
        return $this;
    }

    public function setIncomingPhoneNumberSid(string $incomingPhoneNumberSid): self
    {
        $this->options['incomingPhoneNumberSid'] = $incomingPhoneNumberSid;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.HostedNumbers.ReadHostedNumberOrderOptions ' . $options . ']';
    }
}

class CreateHostedNumberOrderOptions extends Options
{
    public function __construct(string $accountSid = Values::NONE, string $friendlyName = Values::NONE, string $uniqueName = Values::NONE, array $ccEmails = Values::ARRAY_NONE, string $smsUrl = Values::NONE, string $smsMethod = Values::NONE, string $smsFallbackUrl = Values::NONE, string $smsFallbackMethod = Values::NONE, string $statusCallbackUrl = Values::NONE, string $statusCallbackMethod = Values::NONE, string $smsApplicationSid = Values::NONE, string $addressSid = Values::NONE, string $email = Values::NONE, string $verificationType = Values::NONE, string $verificationDocumentSid = Values::NONE)
    {
        $this->options['accountSid'] = $accountSid;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['uniqueName'] = $uniqueName;
        $this->options['ccEmails'] = $ccEmails;
        $this->options['smsUrl'] = $smsUrl;
        $this->options['smsMethod'] = $smsMethod;
        $this->options['smsFallbackUrl'] = $smsFallbackUrl;
        $this->options['smsFallbackMethod'] = $smsFallbackMethod;
        $this->options['statusCallbackUrl'] = $statusCallbackUrl;
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
        $this->options['smsApplicationSid'] = $smsApplicationSid;
        $this->options['addressSid'] = $addressSid;
        $this->options['email'] = $email;
        $this->options['verificationType'] = $verificationType;
        $this->options['verificationDocumentSid'] = $verificationDocumentSid;
    }

    public function setAccountSid(string $accountSid): self
    {
        $this->options['accountSid'] = $accountSid;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function setCcEmails(array $ccEmails): self
    {
        $this->options['ccEmails'] = $ccEmails;
        return $this;
    }

    public function setSmsUrl(string $smsUrl): self
    {
        $this->options['smsUrl'] = $smsUrl;
        return $this;
    }

    public function setSmsMethod(string $smsMethod): self
    {
        $this->options['smsMethod'] = $smsMethod;
        return $this;
    }

    public function setSmsFallbackUrl(string $smsFallbackUrl): self
    {
        $this->options['smsFallbackUrl'] = $smsFallbackUrl;
        return $this;
    }

    public function setSmsFallbackMethod(string $smsFallbackMethod): self
    {
        $this->options['smsFallbackMethod'] = $smsFallbackMethod;
        return $this;
    }

    public function setStatusCallbackUrl(string $statusCallbackUrl): self
    {
        $this->options['statusCallbackUrl'] = $statusCallbackUrl;
        return $this;
    }

    public function setStatusCallbackMethod(string $statusCallbackMethod): self
    {
        $this->options['statusCallbackMethod'] = $statusCallbackMethod;
        return $this;
    }

    public function setSmsApplicationSid(string $smsApplicationSid): self
    {
        $this->options['smsApplicationSid'] = $smsApplicationSid;
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

    public function setVerificationType(string $verificationType): self
    {
        $this->options['verificationType'] = $verificationType;
        return $this;
    }

    public function setVerificationDocumentSid(string $verificationDocumentSid): self
    {
        $this->options['verificationDocumentSid'] = $verificationDocumentSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.HostedNumbers.CreateHostedNumberOrderOptions ' . $options . ']';
    }
}