<?php

namespace Facebook\Authentication;

use DateTime;
use Facebook\Exceptions\FacebookSDKException;

class AccessTokenMetadata
{
    protected static $dateProperties = ['expires_at', 'issued_at'];
    protected $metadata = [];

    public function __construct(array $metadata)
    {
        if (!isset($metadata['data'])) {
            throw new FacebookSDKException('Unexpected debug token response data.', 401);
        }
        $this->metadata = $metadata['data'];
        $this->castTimestampsToDateTime();
    }

    private function castTimestampsToDateTime()
    {
        foreach (static::$dateProperties as $key) {
            if (isset($this->metadata[$key]) && $this->metadata[$key] !== 0) {
                $this->metadata[$key] = $this->convertTimestampToDateTime($this->metadata[$key]);
            }
        }
    }

    private function convertTimestampToDateTime($timestamp)
    {
        $dt = new DateTime();
        $dt->setTimestamp($timestamp);
        return $dt;
    }

    public function getProperty($field, $default = null)
    {
        return $this->getField($field, $default);
    }

    public function getField($field, $default = null)
    {
        if (isset($this->metadata[$field])) {
            return $this->metadata[$field];
        }
        return $default;
    }

    public function getApplication()
    {
        return $this->getField('application');
    }

    public function isError()
    {
        return $this->getField('error') !== null;
    }

    public function getErrorCode()
    {
        return $this->getErrorProperty('code');
    }

    public function getErrorProperty($field, $default = null)
    {
        return $this->getChildProperty('error', $field, $default);
    }

    public function getChildProperty($parentField, $field, $default = null)
    {
        if (!isset($this->metadata[$parentField])) {
            return $default;
        }
        if (!isset($this->metadata[$parentField][$field])) {
            return $default;
        }
        return $this->metadata[$parentField][$field];
    }

    public function getErrorMessage()
    {
        return $this->getErrorProperty('message');
    }

    public function getErrorSubcode()
    {
        return $this->getErrorProperty('subcode');
    }

    public function getIsValid()
    {
        return $this->getField('is_valid');
    }

    public function getIssuedAt()
    {
        return $this->getField('issued_at');
    }

    public function getMetadata()
    {
        return $this->getField('metadata');
    }

    public function getSso()
    {
        return $this->getMetadataProperty('sso');
    }

    public function getMetadataProperty($field, $default = null)
    {
        return $this->getChildProperty('metadata', $field, $default);
    }

    public function getAuthType()
    {
        return $this->getMetadataProperty('auth_type');
    }

    public function getAuthNonce()
    {
        return $this->getMetadataProperty('auth_nonce');
    }

    public function getProfileId()
    {
        return $this->getField('profile_id');
    }

    public function getScopes()
    {
        return $this->getField('scopes');
    }

    public function validateAppId($appId)
    {
        if ($this->getAppId() !== $appId) {
            throw new FacebookSDKException('Access token metadata contains unexpected app ID.', 401);
        }
    }

    public function getAppId()
    {
        return $this->getField('app_id');
    }

    public function validateUserId($userId)
    {
        if ($this->getUserId() !== $userId) {
            throw new FacebookSDKException('Access token metadata contains unexpected user ID.', 401);
        }
    }

    public function getUserId()
    {
        return $this->getField('user_id');
    }

    public function validateExpiration()
    {
        if (!$this->getExpiresAt() instanceof DateTime) {
            return;
        }
        if ($this->getExpiresAt()->getTimestamp() < time()) {
            throw new FacebookSDKException('Inspection of access token metadata shows that the access token has expired.', 401);
        }
    }

    public function getExpiresAt()
    {
        return $this->getField('expires_at');
    }
}