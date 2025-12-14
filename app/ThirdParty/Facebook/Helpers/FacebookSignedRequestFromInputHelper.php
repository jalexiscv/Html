<?php

namespace Facebook\Helpers;

use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Facebook\FacebookApp;
use Facebook\FacebookClient;
use Facebook\SignedRequest;
use Facebook\Authentication\AccessToken;
use Facebook\Authentication\OAuth2Client;

abstract class FacebookSignedRequestFromInputHelper
{
    protected $signedRequest;
    protected $app;
    protected $oAuth2Client;

    public function __construct(FacebookApp $app, FacebookClient $client, $graphVersion = null)
    {
        $this->app = $app;
        $graphVersion = $graphVersion ?: Facebook::DEFAULT_GRAPH_VERSION;
        $this->oAuth2Client = new OAuth2Client($this->app, $client, $graphVersion);
        $this->instantiateSignedRequest();
    }

    public function instantiateSignedRequest($rawSignedRequest = null)
    {
        $rawSignedRequest = $rawSignedRequest ?: $this->getRawSignedRequest();
        if (!$rawSignedRequest) {
            return;
        }
        $this->signedRequest = new SignedRequest($this->app, $rawSignedRequest);
    }

    public function getAccessToken()
    {
        if ($this->signedRequest && $this->signedRequest->hasOAuthData()) {
            $code = $this->signedRequest->get('code');
            $accessToken = $this->signedRequest->get('oauth_token');
            if ($code && !$accessToken) {
                return $this->oAuth2Client->getAccessTokenFromCode($code);
            }
            $expiresAt = $this->signedRequest->get('expires', 0);
            return new AccessToken($accessToken, $expiresAt);
        }
        return null;
    }

    public function getSignedRequest()
    {
        return $this->signedRequest;
    }

    public function getUserId()
    {
        return $this->signedRequest ? $this->signedRequest->getUserId() : null;
    }

    abstract public function getRawSignedRequest();

    public function getRawSignedRequestFromPost()
    {
        if (isset($_POST['signed_request'])) {
            return $_POST['signed_request'];
        }
        return null;
    }

    public function getRawSignedRequestFromCookie()
    {
        if (isset($_COOKIE['fbsr_' . $this->app->getId()])) {
            return $_COOKIE['fbsr_' . $this->app->getId()];
        }
        return null;
    }
}