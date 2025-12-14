<?php

namespace Facebook\Helpers;
class FacebookCanvasHelper extends FacebookSignedRequestFromInputHelper
{
    public function getAppData()
    {
        return $this->signedRequest ? $this->signedRequest->get('app_data') : null;
    }

    public function getRawSignedRequest()
    {
        return $this->getRawSignedRequestFromPost() ?: null;
    }
}