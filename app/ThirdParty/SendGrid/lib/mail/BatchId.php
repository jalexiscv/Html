<?php

namespace SendGrid\Mail;

use JsonSerializable;

class BatchId implements JsonSerializable
{
    private $batch_id;

    public function __construct($batch_id = null)
    {
        if (isset($batch_id)) {
            $this->setBatchId($batch_id);
        }
    }

    public function setBatchId($batch_id)
    {
        if (!is_string($batch_id)) {
            throw new TypeException('$batch_id must be of type string.');
        }
        $this->batch_id = $batch_id;
    }

    public function getBatchId()
    {
        return $this->batch_id;
    }

    public function jsonSerialize()
    {
        return $this->getBatchId();
    }
}
