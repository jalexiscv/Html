<?php

namespace Twilio\Exceptions;
class RestException extends TwilioException
{
    protected $statusCode;
    protected $details;
    protected $moreInfo;

    public function __construct(string $message, int $code, int $statusCode, string $moreInfo = '', array $details = [])
    {
        $this->statusCode = $statusCode;
        $this->moreInfo = $moreInfo;
        $this->details = $details;
        parent::__construct($message, $code);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getMoreInfo(): string
    {
        return $this->moreInfo;
    }

    public function getDetails(): array
    {
        return $this->details;
    }
}