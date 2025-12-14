<?php

namespace Facebook\Exceptions;
class FacebookResumableUploadException extends FacebookSDKException
{
    protected $startOffset;
    protected $endOffset;

    public function getStartOffset()
    {
        return $this->startOffset;
    }

    public function setStartOffset($startOffset)
    {
        $this->startOffset = $startOffset;
    }

    public function getEndOffset()
    {
        return $this->endOffset;
    }

    public function setEndOffset($endOffset)
    {
        $this->endOffset = $endOffset;
    }
}