<?php

namespace Facebook\GraphNodes;

use DateTime;

class GraphSessionInfo extends GraphNode
{
    public function getAppId()
    {
        return $this->getField('app_id');
    }

    public function getApplication()
    {
        return $this->getField('application');
    }

    public function getExpiresAt()
    {
        return $this->getField('expires_at');
    }

    public function getIsValid()
    {
        return $this->getField('is_valid');
    }

    public function getIssuedAt()
    {
        return $this->getField('issued_at');
    }

    public function getScopes()
    {
        return $this->getField('scopes');
    }

    public function getUserId()
    {
        return $this->getField('user_id');
    }
}