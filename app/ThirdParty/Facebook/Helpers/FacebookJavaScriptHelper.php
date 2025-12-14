<?php

namespace Facebook\Helpers;
class FacebookJavaScriptHelper extends FacebookSignedRequestFromInputHelper
{
    public function getRawSignedRequest()
    {
        return $this->getRawSignedRequestFromCookie();
    }
}