<?php

class AppConf
{
    private $clientId = null;
    private $clientSecret = null;
    private $apiKey = null;
    private $authUri = null;
    private $authGrantType = null;
    private $apiBasePath = null;

    public function __construct()
    {
        $this->loadEnvVars();
    }

    private function loadEnvVars()
    {
        $this->clientId = "3gfqb8prd9smcmoua89rr7cq23";
        $this->clientSecret = "10uq1nkfllt3mg9njmbhtck97h25lvc54ahubnmtj9sq8do90umq";
        $this->apiKey = "RYbnUtjVbt9zDyza6TKeU56mJAMJVpRV8TqHwtA5";
        $this->authUri = "https://oauth.sandbox.nequi.com/oauth2/token";
        $this->authGrantType = "client_credentials";
        $this->apiBasePath = "https://api.sandbox.nequi.com";
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function getAuthUri()
    {
        return $this->authUri;
    }

    public function getAuthGrantType()
    {
        return $this->authGrantType;
    }

    public function getApiBasePath()
    {
        return $this->apiBasePath;
    }
} ?>