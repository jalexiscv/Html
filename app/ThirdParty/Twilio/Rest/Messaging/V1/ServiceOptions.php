<?php

namespace Twilio\Rest\Messaging\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ServiceOptions
{
    public static function create(string $inboundRequestUrl = Values::NONE, string $inboundMethod = Values::NONE, string $fallbackUrl = Values::NONE, string $fallbackMethod = Values::NONE, string $statusCallback = Values::NONE, bool $stickySender = Values::NONE, bool $mmsConverter = Values::NONE, bool $smartEncoding = Values::NONE, string $scanMessageContent = Values::NONE, bool $fallbackToLongCode = Values::NONE, bool $areaCodeGeomatch = Values::NONE, int $validityPeriod = Values::NONE, bool $synchronousValidation = Values::NONE): CreateServiceOptions
    {
        return new CreateServiceOptions($inboundRequestUrl, $inboundMethod, $fallbackUrl, $fallbackMethod, $statusCallback, $stickySender, $mmsConverter, $smartEncoding, $scanMessageContent, $fallbackToLongCode, $areaCodeGeomatch, $validityPeriod, $synchronousValidation);
    }

    public static function update(string $friendlyName = Values::NONE, string $inboundRequestUrl = Values::NONE, string $inboundMethod = Values::NONE, string $fallbackUrl = Values::NONE, string $fallbackMethod = Values::NONE, string $statusCallback = Values::NONE, bool $stickySender = Values::NONE, bool $mmsConverter = Values::NONE, bool $smartEncoding = Values::NONE, string $scanMessageContent = Values::NONE, bool $fallbackToLongCode = Values::NONE, bool $areaCodeGeomatch = Values::NONE, int $validityPeriod = Values::NONE, bool $synchronousValidation = Values::NONE): UpdateServiceOptions
    {
        return new UpdateServiceOptions($friendlyName, $inboundRequestUrl, $inboundMethod, $fallbackUrl, $fallbackMethod, $statusCallback, $stickySender, $mmsConverter, $smartEncoding, $scanMessageContent, $fallbackToLongCode, $areaCodeGeomatch, $validityPeriod, $synchronousValidation);
    }
}

class CreateServiceOptions extends Options
{
    public function __construct(string $inboundRequestUrl = Values::NONE, string $inboundMethod = Values::NONE, string $fallbackUrl = Values::NONE, string $fallbackMethod = Values::NONE, string $statusCallback = Values::NONE, bool $stickySender = Values::NONE, bool $mmsConverter = Values::NONE, bool $smartEncoding = Values::NONE, string $scanMessageContent = Values::NONE, bool $fallbackToLongCode = Values::NONE, bool $areaCodeGeomatch = Values::NONE, int $validityPeriod = Values::NONE, bool $synchronousValidation = Values::NONE)
    {
        $this->options['inboundRequestUrl'] = $inboundRequestUrl;
        $this->options['inboundMethod'] = $inboundMethod;
        $this->options['fallbackUrl'] = $fallbackUrl;
        $this->options['fallbackMethod'] = $fallbackMethod;
        $this->options['statusCallback'] = $statusCallback;
        $this->options['stickySender'] = $stickySender;
        $this->options['mmsConverter'] = $mmsConverter;
        $this->options['smartEncoding'] = $smartEncoding;
        $this->options['scanMessageContent'] = $scanMessageContent;
        $this->options['fallbackToLongCode'] = $fallbackToLongCode;
        $this->options['areaCodeGeomatch'] = $areaCodeGeomatch;
        $this->options['validityPeriod'] = $validityPeriod;
        $this->options['synchronousValidation'] = $synchronousValidation;
    }

    public function setInboundRequestUrl(string $inboundRequestUrl): self
    {
        $this->options['inboundRequestUrl'] = $inboundRequestUrl;
        return $this;
    }

    public function setInboundMethod(string $inboundMethod): self
    {
        $this->options['inboundMethod'] = $inboundMethod;
        return $this;
    }

    public function setFallbackUrl(string $fallbackUrl): self
    {
        $this->options['fallbackUrl'] = $fallbackUrl;
        return $this;
    }

    public function setFallbackMethod(string $fallbackMethod): self
    {
        $this->options['fallbackMethod'] = $fallbackMethod;
        return $this;
    }

    public function setStatusCallback(string $statusCallback): self
    {
        $this->options['statusCallback'] = $statusCallback;
        return $this;
    }

    public function setStickySender(bool $stickySender): self
    {
        $this->options['stickySender'] = $stickySender;
        return $this;
    }

    public function setMmsConverter(bool $mmsConverter): self
    {
        $this->options['mmsConverter'] = $mmsConverter;
        return $this;
    }

    public function setSmartEncoding(bool $smartEncoding): self
    {
        $this->options['smartEncoding'] = $smartEncoding;
        return $this;
    }

    public function setScanMessageContent(string $scanMessageContent): self
    {
        $this->options['scanMessageContent'] = $scanMessageContent;
        return $this;
    }

    public function setFallbackToLongCode(bool $fallbackToLongCode): self
    {
        $this->options['fallbackToLongCode'] = $fallbackToLongCode;
        return $this;
    }

    public function setAreaCodeGeomatch(bool $areaCodeGeomatch): self
    {
        $this->options['areaCodeGeomatch'] = $areaCodeGeomatch;
        return $this;
    }

    public function setValidityPeriod(int $validityPeriod): self
    {
        $this->options['validityPeriod'] = $validityPeriod;
        return $this;
    }

    public function setSynchronousValidation(bool $synchronousValidation): self
    {
        $this->options['synchronousValidation'] = $synchronousValidation;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Messaging.V1.CreateServiceOptions ' . $options . ']';
    }
}

class UpdateServiceOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $inboundRequestUrl = Values::NONE, string $inboundMethod = Values::NONE, string $fallbackUrl = Values::NONE, string $fallbackMethod = Values::NONE, string $statusCallback = Values::NONE, bool $stickySender = Values::NONE, bool $mmsConverter = Values::NONE, bool $smartEncoding = Values::NONE, string $scanMessageContent = Values::NONE, bool $fallbackToLongCode = Values::NONE, bool $areaCodeGeomatch = Values::NONE, int $validityPeriod = Values::NONE, bool $synchronousValidation = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['inboundRequestUrl'] = $inboundRequestUrl;
        $this->options['inboundMethod'] = $inboundMethod;
        $this->options['fallbackUrl'] = $fallbackUrl;
        $this->options['fallbackMethod'] = $fallbackMethod;
        $this->options['statusCallback'] = $statusCallback;
        $this->options['stickySender'] = $stickySender;
        $this->options['mmsConverter'] = $mmsConverter;
        $this->options['smartEncoding'] = $smartEncoding;
        $this->options['scanMessageContent'] = $scanMessageContent;
        $this->options['fallbackToLongCode'] = $fallbackToLongCode;
        $this->options['areaCodeGeomatch'] = $areaCodeGeomatch;
        $this->options['validityPeriod'] = $validityPeriod;
        $this->options['synchronousValidation'] = $synchronousValidation;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setInboundRequestUrl(string $inboundRequestUrl): self
    {
        $this->options['inboundRequestUrl'] = $inboundRequestUrl;
        return $this;
    }

    public function setInboundMethod(string $inboundMethod): self
    {
        $this->options['inboundMethod'] = $inboundMethod;
        return $this;
    }

    public function setFallbackUrl(string $fallbackUrl): self
    {
        $this->options['fallbackUrl'] = $fallbackUrl;
        return $this;
    }

    public function setFallbackMethod(string $fallbackMethod): self
    {
        $this->options['fallbackMethod'] = $fallbackMethod;
        return $this;
    }

    public function setStatusCallback(string $statusCallback): self
    {
        $this->options['statusCallback'] = $statusCallback;
        return $this;
    }

    public function setStickySender(bool $stickySender): self
    {
        $this->options['stickySender'] = $stickySender;
        return $this;
    }

    public function setMmsConverter(bool $mmsConverter): self
    {
        $this->options['mmsConverter'] = $mmsConverter;
        return $this;
    }

    public function setSmartEncoding(bool $smartEncoding): self
    {
        $this->options['smartEncoding'] = $smartEncoding;
        return $this;
    }

    public function setScanMessageContent(string $scanMessageContent): self
    {
        $this->options['scanMessageContent'] = $scanMessageContent;
        return $this;
    }

    public function setFallbackToLongCode(bool $fallbackToLongCode): self
    {
        $this->options['fallbackToLongCode'] = $fallbackToLongCode;
        return $this;
    }

    public function setAreaCodeGeomatch(bool $areaCodeGeomatch): self
    {
        $this->options['areaCodeGeomatch'] = $areaCodeGeomatch;
        return $this;
    }

    public function setValidityPeriod(int $validityPeriod): self
    {
        $this->options['validityPeriod'] = $validityPeriod;
        return $this;
    }

    public function setSynchronousValidation(bool $synchronousValidation): self
    {
        $this->options['synchronousValidation'] = $synchronousValidation;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Messaging.V1.UpdateServiceOptions ' . $options . ']';
    }
}