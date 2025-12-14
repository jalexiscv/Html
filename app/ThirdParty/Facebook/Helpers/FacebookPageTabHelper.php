<?php

namespace Facebook\Helpers;

use Facebook\FacebookApp;
use Facebook\FacebookClient;

class FacebookPageTabHelper extends FacebookCanvasHelper
{
    protected $pageData;

    public function __construct(FacebookApp $app, FacebookClient $client, $graphVersion = null)
    {
        parent::__construct($app, $client, $graphVersion);
        if (!$this->signedRequest) {
            return;
        }
        $this->pageData = $this->signedRequest->get('page');
    }

    public function getPageData($key, $default = null)
    {
        if (isset($this->pageData[$key])) {
            return $this->pageData[$key];
        }
        return $default;
    }

    public function isAdmin()
    {
        return $this->getPageData('admin') === true;
    }

    public function getPageId()
    {
        return $this->getPageData('id');
    }
}