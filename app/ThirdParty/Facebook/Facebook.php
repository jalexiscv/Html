<?php

namespace Facebook;

use Facebook\Authentication\AccessToken;
use Facebook\Authentication\OAuth2Client;
use Facebook\FileUpload\FacebookFile;
use Facebook\FileUpload\FacebookResumableUploader;
use Facebook\FileUpload\FacebookTransferChunk;
use Facebook\FileUpload\FacebookVideo;
use Facebook\GraphNodes\GraphEdge;
use Facebook\Url\UrlDetectionInterface;
use Facebook\Url\FacebookUrlDetectionHandler;
use Facebook\PseudoRandomString\PseudoRandomStringGeneratorFactory;
use Facebook\PseudoRandomString\PseudoRandomStringGeneratorInterface;
use Facebook\HttpClients\HttpClientsFactory;
use Facebook\PersistentData\PersistentDataFactory;
use Facebook\PersistentData\PersistentDataInterface;
use Facebook\Helpers\FacebookCanvasHelper;
use Facebook\Helpers\FacebookJavaScriptHelper;
use Facebook\Helpers\FacebookPageTabHelper;
use Facebook\Helpers\FacebookRedirectLoginHelper;
use Facebook\Exceptions\FacebookSDKException;
use InvalidArgumentException;

class Facebook
{
    const VERSION = '5.7.0';
    const DEFAULT_GRAPH_VERSION = 'v2.10';
    const APP_ID_ENV_NAME = 'FACEBOOK_APP_ID';
    const APP_SECRET_ENV_NAME = 'FACEBOOK_APP_SECRET';
    protected $app;
    protected $client;
    protected $oAuth2Client;
    protected $urlDetectionHandler;
    protected $pseudoRandomStringGenerator;
    protected $defaultAccessToken;
    protected $defaultGraphVersion;
    protected $persistentDataHandler;
    protected $lastResponse;

    public function __construct(array $config = [])
    {
        $config = array_merge(['app_id' => getenv(static::APP_ID_ENV_NAME), 'app_secret' => getenv(static::APP_SECRET_ENV_NAME), 'default_graph_version' => static::DEFAULT_GRAPH_VERSION, 'enable_beta_mode' => false, 'http_client_handler' => null, 'persistent_data_handler' => null, 'pseudo_random_string_generator' => null, 'url_detection_handler' => null,], $config);
        if (!$config['app_id']) {
            throw new FacebookSDKException('Required "app_id" key not supplied in config and could not find fallback environment variable "' . static::APP_ID_ENV_NAME . '"');
        }
        if (!$config['app_secret']) {
            throw new FacebookSDKException('Required "app_secret" key not supplied in config and could not find fallback environment variable "' . static::APP_SECRET_ENV_NAME . '"');
        }
        $this->app = new FacebookApp($config['app_id'], $config['app_secret']);
        $this->client = new FacebookClient(HttpClientsFactory::createHttpClient($config['http_client_handler']), $config['enable_beta_mode']);
        $this->pseudoRandomStringGenerator = PseudoRandomStringGeneratorFactory::createPseudoRandomStringGenerator($config['pseudo_random_string_generator']);
        $this->setUrlDetectionHandler($config['url_detection_handler'] ?: new FacebookUrlDetectionHandler());
        $this->persistentDataHandler = PersistentDataFactory::createPersistentDataHandler($config['persistent_data_handler']);
        if (isset($config['default_access_token'])) {
            $this->setDefaultAccessToken($config['default_access_token']);
        }
        $this->defaultGraphVersion = $config['default_graph_version'];
    }

    public function getApp()
    {
        return $this->app;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getOAuth2Client()
    {
        if (!$this->oAuth2Client instanceof OAuth2Client) {
            $app = $this->getApp();
            $client = $this->getClient();
            $this->oAuth2Client = new OAuth2Client($app, $client, $this->defaultGraphVersion);
        }
        return $this->oAuth2Client;
    }

    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    public function getUrlDetectionHandler()
    {
        return $this->urlDetectionHandler;
    }

    private function setUrlDetectionHandler(UrlDetectionInterface $urlDetectionHandler)
    {
        $this->urlDetectionHandler = $urlDetectionHandler;
    }

    public function getDefaultAccessToken()
    {
        return $this->defaultAccessToken;
    }

    public function setDefaultAccessToken($accessToken)
    {
        if (is_string($accessToken)) {
            $this->defaultAccessToken = new AccessToken($accessToken);
            return;
        }
        if ($accessToken instanceof AccessToken) {
            $this->defaultAccessToken = $accessToken;
            return;
        }
        throw new InvalidArgumentException('The default access token must be of type "string" or Facebook\AccessToken');
    }

    public function getDefaultGraphVersion()
    {
        return $this->defaultGraphVersion;
    }

    public function getRedirectLoginHelper()
    {
        return new FacebookRedirectLoginHelper($this->getOAuth2Client(), $this->persistentDataHandler, $this->urlDetectionHandler, $this->pseudoRandomStringGenerator);
    }

    public function getJavaScriptHelper()
    {
        return new FacebookJavaScriptHelper($this->app, $this->client, $this->defaultGraphVersion);
    }

    public function getCanvasHelper()
    {
        return new FacebookCanvasHelper($this->app, $this->client, $this->defaultGraphVersion);
    }

    public function getPageTabHelper()
    {
        return new FacebookPageTabHelper($this->app, $this->client, $this->defaultGraphVersion);
    }

    public function get($endpoint, $accessToken = null, $eTag = null, $graphVersion = null)
    {
        return $this->sendRequest('GET', $endpoint, $params = [], $accessToken, $eTag, $graphVersion);
    }

    public function post($endpoint, array $params = [], $accessToken = null, $eTag = null, $graphVersion = null)
    {
        return $this->sendRequest('POST', $endpoint, $params, $accessToken, $eTag, $graphVersion);
    }

    public function delete($endpoint, array $params = [], $accessToken = null, $eTag = null, $graphVersion = null)
    {
        return $this->sendRequest('DELETE', $endpoint, $params, $accessToken, $eTag, $graphVersion);
    }

    public function next(GraphEdge $graphEdge)
    {
        return $this->getPaginationResults($graphEdge, 'next');
    }

    public function previous(GraphEdge $graphEdge)
    {
        return $this->getPaginationResults($graphEdge, 'previous');
    }

    public function getPaginationResults(GraphEdge $graphEdge, $direction)
    {
        $paginationRequest = $graphEdge->getPaginationRequest($direction);
        if (!$paginationRequest) {
            return null;
        }
        $this->lastResponse = $this->client->sendRequest($paginationRequest);
        $subClassName = $graphEdge->getSubClassName();
        $graphEdge = $this->lastResponse->getGraphEdge($subClassName, false);
        return count($graphEdge) > 0 ? $graphEdge : null;
    }

    public function sendRequest($method, $endpoint, array $params = [], $accessToken = null, $eTag = null, $graphVersion = null)
    {
        $accessToken = $accessToken ?: $this->defaultAccessToken;
        $graphVersion = $graphVersion ?: $this->defaultGraphVersion;
        $request = $this->request($method, $endpoint, $params, $accessToken, $eTag, $graphVersion);
        return $this->lastResponse = $this->client->sendRequest($request);
    }

    public function sendBatchRequest(array $requests, $accessToken = null, $graphVersion = null)
    {
        $accessToken = $accessToken ?: $this->defaultAccessToken;
        $graphVersion = $graphVersion ?: $this->defaultGraphVersion;
        $batchRequest = new FacebookBatchRequest($this->app, $requests, $accessToken, $graphVersion);
        return $this->lastResponse = $this->client->sendBatchRequest($batchRequest);
    }

    public function newBatchRequest($accessToken = null, $graphVersion = null)
    {
        $accessToken = $accessToken ?: $this->defaultAccessToken;
        $graphVersion = $graphVersion ?: $this->defaultGraphVersion;
        return new FacebookBatchRequest($this->app, [], $accessToken, $graphVersion);
    }

    public function request($method, $endpoint, array $params = [], $accessToken = null, $eTag = null, $graphVersion = null)
    {
        $accessToken = $accessToken ?: $this->defaultAccessToken;
        $graphVersion = $graphVersion ?: $this->defaultGraphVersion;
        return new FacebookRequest($this->app, $accessToken, $method, $endpoint, $params, $eTag, $graphVersion);
    }

    public function fileToUpload($pathToFile)
    {
        return new FacebookFile($pathToFile);
    }

    public function videoToUpload($pathToFile)
    {
        return new FacebookVideo($pathToFile);
    }

    public function uploadVideo($target, $pathToFile, $metadata = [], $accessToken = null, $maxTransferTries = 5, $graphVersion = null)
    {
        $accessToken = $accessToken ?: $this->defaultAccessToken;
        $graphVersion = $graphVersion ?: $this->defaultGraphVersion;
        $uploader = new FacebookResumableUploader($this->app, $this->client, $accessToken, $graphVersion);
        $endpoint = '/' . $target . '/videos';
        $file = $this->videoToUpload($pathToFile);
        $chunk = $uploader->start($endpoint, $file);
        do {
            $chunk = $this->maxTriesTransfer($uploader, $endpoint, $chunk, $maxTransferTries);
        } while (!$chunk->isLastChunk());
        return ['video_id' => $chunk->getVideoId(), 'success' => $uploader->finish($endpoint, $chunk->getUploadSessionId(), $metadata),];
    }

    private function maxTriesTransfer(FacebookResumableUploader $uploader, $endpoint, FacebookTransferChunk $chunk, $retryCountdown)
    {
        $newChunk = $uploader->transfer($endpoint, $chunk, $retryCountdown < 1);
        if ($newChunk !== $chunk) {
            return $newChunk;
        }
        $retryCountdown--;
        return $this->maxTriesTransfer($uploader, $endpoint, $chunk, $retryCountdown);
    }
}