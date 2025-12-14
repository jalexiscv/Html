<?php

namespace Facebook;

use Facebook\Exceptions\FacebookSDKException;
use function hash_equals;

class SignedRequest
{
    protected $app;
    protected $rawSignedRequest;
    protected $payload;

    public function __construct(FacebookApp $facebookApp, $rawSignedRequest = null)
    {
        $this->app = $facebookApp;
        if (!$rawSignedRequest) {
            return;
        }
        $this->rawSignedRequest = $rawSignedRequest;
        $this->parse();
    }

    public function getRawSignedRequest()
    {
        return $this->rawSignedRequest;
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function get($key, $default = null)
    {
        if (isset($this->payload[$key])) {
            return $this->payload[$key];
        }
        return $default;
    }

    public function getUserId()
    {
        return $this->get('user_id');
    }

    public function hasOAuthData()
    {
        return $this->get('oauth_token') || $this->get('code');
    }

    public function make(array $payload)
    {
        $payload['algorithm'] = isset($payload['algorithm']) ? $payload['algorithm'] : 'HMAC-SHA256';
        $payload['issued_at'] = isset($payload['issued_at']) ? $payload['issued_at'] : time();
        $encodedPayload = $this->base64UrlEncode(json_encode($payload));
        $hashedSig = $this->hashSignature($encodedPayload);
        $encodedSig = $this->base64UrlEncode($hashedSig);
        return $encodedSig . '.' . $encodedPayload;
    }

    protected function parse()
    {
        list($encodedSig, $encodedPayload) = $this->split();
        $sig = $this->decodeSignature($encodedSig);
        $hashedSig = $this->hashSignature($encodedPayload);
        $this->validateSignature($hashedSig, $sig);
        $this->payload = $this->decodePayload($encodedPayload);
        $this->validateAlgorithm();
    }

    protected function split()
    {
        if (strpos($this->rawSignedRequest, '.') === false) {
            throw new FacebookSDKException('Malformed signed request.', 606);
        }
        return explode('.', $this->rawSignedRequest, 2);
    }

    protected function decodeSignature($encodedSig)
    {
        $sig = $this->base64UrlDecode($encodedSig);
        if (!$sig) {
            throw new FacebookSDKException('Signed request has malformed encoded signature data.', 607);
        }
        return $sig;
    }

    protected function decodePayload($encodedPayload)
    {
        $payload = $this->base64UrlDecode($encodedPayload);
        if ($payload) {
            $payload = json_decode($payload, true);
        }
        if (!is_array($payload)) {
            throw new FacebookSDKException('Signed request has malformed encoded payload data.', 607);
        }
        return $payload;
    }

    protected function validateAlgorithm()
    {
        if ($this->get('algorithm') !== 'HMAC-SHA256') {
            throw new FacebookSDKException('Signed request is using the wrong algorithm.', 605);
        }
    }

    protected function hashSignature($encodedData)
    {
        $hashedSig = hash_hmac('sha256', $encodedData, $this->app->getSecret(), $raw_output = true);
        if (!$hashedSig) {
            throw new FacebookSDKException('Unable to hash signature from encoded payload data.', 602);
        }
        return $hashedSig;
    }

    protected function validateSignature($hashedSig, $sig)
    {
        if (hash_equals($hashedSig, $sig)) {
            return;
        }
        throw new FacebookSDKException('Signed request has an invalid signature.', 602);
    }

    public function base64UrlDecode($input)
    {
        $urlDecodedBase64 = strtr($input, '-_', '+/');
        $this->validateBase64($urlDecodedBase64);
        return base64_decode($urlDecodedBase64);
    }

    public function base64UrlEncode($input)
    {
        return strtr(base64_encode($input), '+/', '-_');
    }

    protected function validateBase64($input)
    {
        if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $input)) {
            throw new FacebookSDKException('Signed request contains malformed base64 encoding.', 608);
        }
    }
}