<?php

namespace Facebook\Authentication;

use Facebook\Facebook;
use Facebook\FacebookApp;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookClient;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

class OAuth2Client
{
    const BASE_AUTHORIZATION_URL = 'https://www.facebook.com';
    protected $app;
    protected $client;
    protected $graphVersion;
    protected $lastRequest;

    public function __construct(FacebookApp $app, FacebookClient $client, $graphVersion = null)
    {
        $this->app = $app;
        $this->client = $client;
        $this->graphVersion = $graphVersion ?: Facebook::DEFAULT_GRAPH_VERSION;
    }

    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    public function debugToken($accessToken)
    {
        $accessToken = $accessToken instanceof AccessToken ? $accessToken->getValue() : $accessToken;
        $params = ['input_token' => $accessToken];
        $this->lastRequest = new FacebookRequest($this->app, $this->app->getAccessToken(), 'GET', '/debug_token', $params, null, $this->graphVersion);
        $response = $this->client->sendRequest($this->lastRequest);
        $metadata = $response->getDecodedBody();
        return new AccessTokenMetadata($metadata);
    }

    public function getAuthorizationUrl($redirectUrl, $state, array $scope = [], array $params = [], $separator = '&')
    {
        $params += ['client_id' => $this->app->getId(), 'state' => $state, 'response_type' => 'code', 'sdk' => 'php-sdk-' . Facebook::VERSION, 'redirect_uri' => $redirectUrl, 'scope' => implode(',', $scope)];
        return static::BASE_AUTHORIZATION_URL . '/' . $this->graphVersion . '/dialog/oauth?' . http_build_query($params, null, $separator);
    }

    public function getAccessTokenFromCode($code, $redirectUri = '')
    {
        $params = ['code' => $code, 'redirect_uri' => $redirectUri,];
        return $this->requestAnAccessToken($params);
    }

    public function getLongLivedAccessToken($accessToken)
    {
        $accessToken = $accessToken instanceof AccessToken ? $accessToken->getValue() : $accessToken;
        $params = ['grant_type' => 'fb_exchange_token', 'fb_exchange_token' => $accessToken,];
        return $this->requestAnAccessToken($params);
    }

    public function getCodeFromLongLivedAccessToken($accessToken, $redirectUri = '')
    {
        $params = ['redirect_uri' => $redirectUri,];
        $response = $this->sendRequestWithClientParams('/oauth/client_code', $params, $accessToken);
        $data = $response->getDecodedBody();
        if (!isset($data['code'])) {
            throw new FacebookSDKException('Code was not returned from Graph.', 401);
        }
        return $data['code'];
    }

    protected function requestAnAccessToken(array $params)
    {
        $response = $this->sendRequestWithClientParams('/oauth/access_token', $params);
        $data = $response->getDecodedBody();
        if (!isset($data['access_token'])) {
            throw new FacebookSDKException('Access token was not returned from Graph.', 401);
        }
        $expiresAt = 0;
        if (isset($data['expires'])) {
            $expiresAt = time() + $data['expires'];
        } elseif (isset($data['expires_in'])) {
            $expiresAt = time() + $data['expires_in'];
        }
        return new AccessToken($data['access_token'], $expiresAt);
    }

    protected function sendRequestWithClientParams($endpoint, array $params, $accessToken = null)
    {
        $params += $this->getClientParams();
        $accessToken = $accessToken ?: $this->app->getAccessToken();
        $this->lastRequest = new FacebookRequest($this->app, $accessToken, 'GET', $endpoint, $params, null, $this->graphVersion);
        return $this->client->sendRequest($this->lastRequest);
    }

    protected function getClientParams()
    {
        return ['client_id' => $this->app->getId(), 'client_secret' => $this->app->getSecret(),];
    }
}