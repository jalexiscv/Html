<?php

namespace Facebook;

use Facebook\Authentication\AccessToken;
use Facebook\Url\FacebookUrlManipulator;
use Facebook\FileUpload\FacebookFile;
use Facebook\FileUpload\FacebookVideo;
use Facebook\Http\RequestBodyMultipart;
use Facebook\Http\RequestBodyUrlEncoded;
use Facebook\Exceptions\FacebookSDKException;

class FacebookRequest
{
    protected $app;
    protected $accessToken;
    protected $method;
    protected $endpoint;
    protected $headers = [];
    protected $params = [];
    protected $files = [];
    protected $eTag;
    protected $graphVersion;

    public function __construct(FacebookApp $app = null, $accessToken = null, $method = null, $endpoint = null, array $params = [], $eTag = null, $graphVersion = null)
    {
        $this->setApp($app);
        $this->setAccessToken($accessToken);
        $this->setMethod($method);
        $this->setEndpoint($endpoint);
        $this->setParams($params);
        $this->setETag($eTag);
        $this->graphVersion = $graphVersion ?: Facebook::DEFAULT_GRAPH_VERSION;
    }

    public static function getDefaultHeaders()
    {
        return ['User-Agent' => 'fb-php-' . Facebook::VERSION, 'Accept-Encoding' => '*',];
    }

    public function setAccessTokenFromParams($accessToken)
    {
        $existingAccessToken = $this->getAccessToken();
        if (!$existingAccessToken) {
            $this->setAccessToken($accessToken);
        } elseif ($accessToken !== $existingAccessToken) {
            throw new FacebookSDKException('Access token mismatch. The access token provided in the FacebookRequest and the one provided in the URL or POST params do not match.');
        }
        return $this;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        if ($accessToken instanceof AccessToken) {
            $this->accessToken = $accessToken->getValue();
        }
        return $this;
    }

    public function getAccessTokenEntity()
    {
        return $this->accessToken ? new AccessToken($this->accessToken) : null;
    }

    public function getApp()
    {
        return $this->app;
    }

    public function setApp(FacebookApp $app = null)
    {
        $this->app = $app;
    }

    public function getAppSecretProof()
    {
        if (!$accessTokenEntity = $this->getAccessTokenEntity()) {
            return null;
        }
        return $accessTokenEntity->getAppSecretProof($this->app->getSecret());
    }

    public function validateAccessToken()
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            throw new FacebookSDKException('You must provide an access token.');
        }
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = strtoupper($method);
    }

    public function validateMethod()
    {
        if (!$this->method) {
            throw new FacebookSDKException('HTTP method not specified.');
        }
        if (!in_array($this->method, ['GET', 'POST', 'DELETE'])) {
            throw new FacebookSDKException('Invalid HTTP method specified.');
        }
    }

    public function getEndpoint()
    {
        return $this->endpoint;
    }

    public function setEndpoint($endpoint)
    {
        $params = FacebookUrlManipulator::getParamsAsArray($endpoint);
        if (isset($params['access_token'])) {
            $this->setAccessTokenFromParams($params['access_token']);
        }
        $filterParams = ['access_token', 'appsecret_proof'];
        $this->endpoint = FacebookUrlManipulator::removeParamsFromUrl($endpoint, $filterParams);
        return $this;
    }

    public function getHeaders()
    {
        $headers = static::getDefaultHeaders();
        if ($this->eTag) {
            $headers['If-None-Match'] = $this->eTag;
        }
        return array_merge($this->headers, $headers);
    }

    public function setHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);
    }

    public function setETag($eTag)
    {
        $this->eTag = $eTag;
    }

    public function dangerouslySetParams(array $params = [])
    {
        $this->params = array_merge($this->params, $params);
        return $this;
    }

    public function sanitizeFileParams(array $params)
    {
        foreach ($params as $key => $value) {
            if ($value instanceof FacebookFile) {
                $this->addFile($key, $value);
                unset($params[$key]);
            }
        }
        return $params;
    }

    public function addFile($key, FacebookFile $file)
    {
        $this->files[$key] = $file;
    }

    public function resetFiles()
    {
        $this->files = [];
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function containsFileUploads()
    {
        return !empty($this->files);
    }

    public function containsVideoUploads()
    {
        foreach ($this->files as $file) {
            if ($file instanceof FacebookVideo) {
                return true;
            }
        }
        return false;
    }

    public function getMultipartBody()
    {
        $params = $this->getPostParams();
        return new RequestBodyMultipart($params, $this->files);
    }

    public function getUrlEncodedBody()
    {
        $params = $this->getPostParams();
        return new RequestBodyUrlEncoded($params);
    }

    public function getParams()
    {
        $params = $this->params;
        $accessToken = $this->getAccessToken();
        if ($accessToken) {
            $params['access_token'] = $accessToken;
            $params['appsecret_proof'] = $this->getAppSecretProof();
        }
        return $params;
    }

    public function setParams(array $params = [])
    {
        if (isset($params['access_token'])) {
            $this->setAccessTokenFromParams($params['access_token']);
        }
        unset($params['access_token'], $params['appsecret_proof']);
        $params = $this->sanitizeFileParams($params);
        $this->dangerouslySetParams($params);
        return $this;
    }

    public function getPostParams()
    {
        if ($this->getMethod() === 'POST') {
            return $this->getParams();
        }
        return [];
    }

    public function getGraphVersion()
    {
        return $this->graphVersion;
    }

    public function getUrl()
    {
        $this->validateMethod();
        $graphVersion = FacebookUrlManipulator::forceSlashPrefix($this->graphVersion);
        $endpoint = FacebookUrlManipulator::forceSlashPrefix($this->getEndpoint());
        $url = $graphVersion . $endpoint;
        if ($this->getMethod() !== 'POST') {
            $params = $this->getParams();
            $url = FacebookUrlManipulator::appendParamsToUrl($url, $params);
        }
        return $url;
    }
}