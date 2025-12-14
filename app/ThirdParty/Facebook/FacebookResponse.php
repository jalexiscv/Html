<?php

namespace Facebook;

use Facebook\GraphNodes\GraphAlbum;
use Facebook\GraphNodes\GraphEdge;
use Facebook\GraphNodes\GraphEvent;
use Facebook\GraphNodes\GraphGroup;
use Facebook\GraphNodes\GraphList;
use Facebook\GraphNodes\GraphNode;
use Facebook\GraphNodes\GraphNodeFactory;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\GraphNodes\GraphObject;
use Facebook\GraphNodes\GraphPage;
use Facebook\GraphNodes\GraphSessionInfo;
use Facebook\GraphNodes\GraphUser;

class FacebookResponse
{
    protected $httpStatusCode;
    protected $headers;
    protected $body;
    protected $decodedBody = [];
    protected $request;
    protected $thrownException;

    public function __construct(FacebookRequest $request, $body = null, $httpStatusCode = null, array $headers = [])
    {
        $this->request = $request;
        $this->body = $body;
        $this->httpStatusCode = $httpStatusCode;
        $this->headers = $headers;
        $this->decodeBody();
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getApp()
    {
        return $this->request->getApp();
    }

    public function getAccessToken()
    {
        return $this->request->getAccessToken();
    }

    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getDecodedBody()
    {
        return $this->decodedBody;
    }

    public function getAppSecretProof()
    {
        return $this->request->getAppSecretProof();
    }

    public function getETag()
    {
        return isset($this->headers['ETag']) ? $this->headers['ETag'] : null;
    }

    public function getGraphVersion()
    {
        return isset($this->headers['Facebook-API-Version']) ? $this->headers['Facebook-API-Version'] : null;
    }

    public function isError()
    {
        return isset($this->decodedBody['error']);
    }

    public function throwException()
    {
        throw $this->thrownException;
    }

    public function makeException()
    {
        $this->thrownException = FacebookResponseException::create($this);
    }

    public function getThrownException()
    {
        return $this->thrownException;
    }

    public function decodeBody()
    {
        $this->decodedBody = json_decode($this->body, true);
        if ($this->decodedBody === null) {
            $this->decodedBody = [];
            parse_str($this->body, $this->decodedBody);
        } elseif (is_bool($this->decodedBody)) {
            $this->decodedBody = ['success' => $this->decodedBody];
        } elseif (is_numeric($this->decodedBody)) {
            $this->decodedBody = ['id' => $this->decodedBody];
        }
        if (!is_array($this->decodedBody)) {
            $this->decodedBody = [];
        }
        if ($this->isError()) {
            $this->makeException();
        }
    }

    public function getGraphObject($subclassName = null)
    {
        return $this->getGraphNode($subclassName);
    }

    public function getGraphNode($subclassName = null)
    {
        $factory = new GraphNodeFactory($this);
        return $factory->makeGraphNode($subclassName);
    }

    public function getGraphAlbum()
    {
        $factory = new GraphNodeFactory($this);
        return $factory->makeGraphAlbum();
    }

    public function getGraphPage()
    {
        $factory = new GraphNodeFactory($this);
        return $factory->makeGraphPage();
    }

    public function getGraphSessionInfo()
    {
        $factory = new GraphNodeFactory($this);
        return $factory->makeGraphSessionInfo();
    }

    public function getGraphUser()
    {
        $factory = new GraphNodeFactory($this);
        return $factory->makeGraphUser();
    }

    public function getGraphEvent()
    {
        $factory = new GraphNodeFactory($this);
        return $factory->makeGraphEvent();
    }

    public function getGraphGroup()
    {
        $factory = new GraphNodeFactory($this);
        return $factory->makeGraphGroup();
    }

    public function getGraphList($subclassName = null, $auto_prefix = true)
    {
        return $this->getGraphEdge($subclassName, $auto_prefix);
    }

    public function getGraphEdge($subclassName = null, $auto_prefix = true)
    {
        $factory = new GraphNodeFactory($this);
        return $factory->makeGraphEdge($subclassName, $auto_prefix);
    }
}