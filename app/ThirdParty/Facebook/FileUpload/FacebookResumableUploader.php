<?php

namespace Facebook\FileUpload;

use Facebook\Authentication\AccessToken;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookResumableUploadException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\FacebookApp;
use Facebook\FacebookClient;
use Facebook\FacebookRequest;

class FacebookResumableUploader
{
    protected $app;
    protected $accessToken;
    protected $client;
    protected $graphVersion;

    public function __construct(FacebookApp $app, FacebookClient $client, $accessToken, $graphVersion)
    {
        $this->app = $app;
        $this->client = $client;
        $this->accessToken = $accessToken;
        $this->graphVersion = $graphVersion;
    }

    public function start($endpoint, FacebookFile $file)
    {
        $params = ['upload_phase' => 'start', 'file_size' => $file->getSize(),];
        $response = $this->sendUploadRequest($endpoint, $params);
        return new FacebookTransferChunk($file, $response['upload_session_id'], $response['video_id'], $response['start_offset'], $response['end_offset']);
    }

    public function transfer($endpoint, FacebookTransferChunk $chunk, $allowToThrow = false)
    {
        $params = ['upload_phase' => 'transfer', 'upload_session_id' => $chunk->getUploadSessionId(), 'start_offset' => $chunk->getStartOffset(), 'video_file_chunk' => $chunk->getPartialFile(),];
        try {
            $response = $this->sendUploadRequest($endpoint, $params);
        } catch (FacebookResponseException $e) {
            $preException = $e->getPrevious();
            if ($allowToThrow || !$preException instanceof FacebookResumableUploadException) {
                throw $e;
            }
            if (null !== $preException->getStartOffset() && null !== $preException->getEndOffset()) {
                return new FacebookTransferChunk($chunk->getFile(), $chunk->getUploadSessionId(), $chunk->getVideoId(), $preException->getStartOffset(), $preException->getEndOffset());
            }
            return $chunk;
        }
        return new FacebookTransferChunk($chunk->getFile(), $chunk->getUploadSessionId(), $chunk->getVideoId(), $response['start_offset'], $response['end_offset']);
    }

    public function finish($endpoint, $uploadSessionId, $metadata = [])
    {
        $params = array_merge($metadata, ['upload_phase' => 'finish', 'upload_session_id' => $uploadSessionId,]);
        $response = $this->sendUploadRequest($endpoint, $params);
        return $response['success'];
    }

    private function sendUploadRequest($endpoint, $params = [])
    {
        $request = new FacebookRequest($this->app, $this->accessToken, 'POST', $endpoint, $params, null, $this->graphVersion);
        return $this->client->sendRequest($request)->getDecodedBody();
    }
}