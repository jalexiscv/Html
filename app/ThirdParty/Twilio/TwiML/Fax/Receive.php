<?php

namespace Twilio\TwiML\Fax;

use Twilio\TwiML\TwiML;

class Receive extends TwiML
{
    public function __construct($attributes = [])
    {
        parent::__construct('Receive', null, $attributes);
    }

    public function setAction($action): self
    {
        return $this->setAttribute('action', $action);
    }

    public function setMethod($method): self
    {
        return $this->setAttribute('method', $method);
    }

    public function setMediaType($mediaType): self
    {
        return $this->setAttribute('mediaType', $mediaType);
    }

    public function setPageSize($pageSize): self
    {
        return $this->setAttribute('pageSize', $pageSize);
    }

    public function setStoreMedia($storeMedia): self
    {
        return $this->setAttribute('storeMedia', $storeMedia);
    }
}