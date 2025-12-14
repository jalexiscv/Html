<?php

namespace SendGrid\Mail;

use JsonSerializable;

class Attachment implements JsonSerializable
{
    private $content;
    private $type;
    private $filename;
    private $disposition;
    private $content_id;

    public function __construct($content = null, $type = null, $filename = null, $disposition = null, $content_id = null)
    {
        if (isset($content)) {
            $this->setContent($content);
        }
        if (isset($type)) {
            $this->setType($type);
        }
        if (isset($filename)) {
            $this->setFilename($filename);
        }
        if (isset($disposition)) {
            $this->setDisposition($disposition);
        }
        if (isset($content_id)) {
            $this->setContentID($content_id);
        }
    }

    public function setContent($content)
    {
        if (!is_string($content)) {
            throw new TypeException('$content must be of type string.');
        }
        if (!$this->isBase64($content)) {
            $this->content = base64_encode($content);
        } else {
            $this->content = $content;
        }
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setType($type)
    {
        if (!is_string($type)) {
            throw new TypeException('$type must be of type string.');
        }
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setFilename($filename)
    {
        if (!is_string($filename)) {
            throw new TypeException('$filename must be of type string');
        }
        $this->filename = $filename;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function setDisposition($disposition)
    {
        if (!is_string($disposition)) {
            throw new TypeException('$disposition must be of type string.');
        }
        $this->disposition = $disposition;
    }

    public function getDisposition()
    {
        return $this->disposition;
    }

    public function setContentID($content_id)
    {
        if (!is_string($content_id)) {
            throw new TypeException('$content_id must be of type string.');
        }
        $this->content_id = $content_id;
    }

    public function getContentID()
    {
        return $this->content_id;
    }

    private function isBase64($string)
    {
        $decoded_data = base64_decode($string, true);
        $encoded_data = base64_encode($decoded_data);
        if ($encoded_data != $string) {
            return false;
        }
        return true;
    }

    public function jsonSerialize()
    {
        return array_filter(['content' => $this->getContent(), 'type' => $this->getType(), 'filename' => $this->getFilename(), 'disposition' => $this->getDisposition(), 'content_id' => $this->getContentID()], function ($value) {
            return $value !== null;
        }) ?: null;
    }
}
