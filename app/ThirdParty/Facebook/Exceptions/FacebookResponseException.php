<?php

namespace Facebook\Exceptions;

use Facebook\FacebookResponse;

class FacebookResponseException extends FacebookSDKException
{
    protected $response;
    protected $responseData;

    public function __construct(FacebookResponse $response, FacebookSDKException $previousException = null)
    {
        $this->response = $response;
        $this->responseData = $response->getDecodedBody();
        $errorMessage = $this->get('message', 'Unknown error from Graph.');
        $errorCode = $this->get('code', -1);
        parent::__construct($errorMessage, $errorCode, $previousException);
    }

    public static function create(FacebookResponse $response)
    {
        $data = $response->getDecodedBody();
        if (!isset($data['error']['code']) && isset($data['code'])) {
            $data = ['error' => $data];
        }
        $code = isset($data['error']['code']) ? $data['error']['code'] : null;
        $message = isset($data['error']['message']) ? $data['error']['message'] : 'Unknown error from Graph.';
        if (isset($data['error']['error_subcode'])) {
            switch ($data['error']['error_subcode']) {
                case 458:
                case 459:
                case 460:
                case 463:
                case 464:
                case 467:
                    return new static($response, new FacebookAuthenticationException($message, $code));
                case 1363030:
                case 1363019:
                case 1363033:
                case 1363021:
                case 1363041:
                    return new static($response, new FacebookResumableUploadException($message, $code));
                case 1363037:
                    $previousException = new FacebookResumableUploadException($message, $code);
                    $startOffset = isset($data['error']['error_data']['start_offset']) ? (int)$data['error']['error_data']['start_offset'] : null;
                    $previousException->setStartOffset($startOffset);
                    $endOffset = isset($data['error']['error_data']['end_offset']) ? (int)$data['error']['error_data']['end_offset'] : null;
                    $previousException->setEndOffset($endOffset);
                    return new static($response, $previousException);
            }
        }
        switch ($code) {
            case 100:
            case 102:
            case 190:
                return new static($response, new FacebookAuthenticationException($message, $code));
            case 1:
            case 2:
                return new static($response, new FacebookServerException($message, $code));
            case 4:
            case 17:
            case 32:
            case 341:
            case 613:
                return new static($response, new FacebookThrottleException($message, $code));
            case 506:
                return new static($response, new FacebookClientException($message, $code));
        }
        if ($code == 10 || ($code >= 200 && $code <= 299)) {
            return new static($response, new FacebookAuthorizationException($message, $code));
        }
        if (isset($data['error']['type']) && $data['error']['type'] === 'OAuthException') {
            return new static($response, new FacebookAuthenticationException($message, $code));
        }
        return new static($response, new FacebookOtherException($message, $code));
    }

    private function get($key, $default = null)
    {
        if (isset($this->responseData['error'][$key])) {
            return $this->responseData['error'][$key];
        }
        return $default;
    }

    public function getHttpStatusCode()
    {
        return $this->response->getHttpStatusCode();
    }

    public function getSubErrorCode()
    {
        return $this->get('error_subcode', -1);
    }

    public function getErrorType()
    {
        return $this->get('type', '');
    }

    public function getRawResponse()
    {
        return $this->response->getBody();
    }

    public function getResponseData()
    {
        return $this->responseData;
    }

    public function getResponse()
    {
        return $this->response;
    }
}