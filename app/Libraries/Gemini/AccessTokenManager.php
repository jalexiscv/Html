<?php

namespace App\Libraries\Gemini;

use Exception;
use Google\Auth\ApplicationDefaultCredentials;

class AccessTokenManager
{
    const VALID_TIME = 3600;
    private ?string $credentialsPath;
    private ?string $accessToken;
    private $expiresAt = 0;

    public function __construct(string $credentialsPath)
    {
        $this->credentialsPath = $credentialsPath;
    }

    public function getAccessToken(): string
    {
        if (time() > $this->expiresAt) {
            Validate::credentials($this->credentialsPath) or throw new Exception('Error: Credentials validation failed.');
            putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $this->credentialsPath);
            $accessToken = ApplicationDefaultCredentials::getCredentials('https://www.googleapis.com/auth/cloud-platform')->fetchAuthToken();
            if (!isset($accessToken['access_token'])) throw new Exception('Error: Unable to get access token.');
            $this->accessToken = $accessToken['access_token'];
            $this->expiresAt = time() + self::VALID_TIME;
        }
        return $this->accessToken;
    }
}
