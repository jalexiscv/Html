<?php

namespace Facebook;

use Facebook\Authentication\AccessToken;
use Facebook\Exceptions\FacebookSDKException;
use Serializable;

class FacebookApp implements Serializable
{
    protected $id;
    protected $secret;

    public function __construct($id, $secret)
    {
        if (!is_string($id) && !is_int($id)) {
            throw new FacebookSDKException('The "app_id" must be formatted as a string since many app ID\'s are greater than PHP_INT_MAX on some systems.');
        }
        $this->id = (string)$id;
        $this->secret = $secret;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSecret()
    {
        return $this->secret;
    }

    public function getAccessToken()
    {
        return new AccessToken($this->id . '|' . $this->secret);
    }

    public function serialize()
    {
        return implode('|', [$this->id, $this->secret]);
    }

    public function unserialize($serialized)
    {
        list($id, $secret) = explode('|', $serialized);
        $this->__construct($id, $secret);
    }
}