<?php

namespace SendGrid\Mail;

use JsonSerializable;

class Ganalytics implements JsonSerializable
{
    private $enable;
    private $utm_source;
    private $utm_medium;
    private $utm_term;
    private $utm_content;
    private $utm_campaign;

    public function __construct($enable = null, $utm_source = null, $utm_medium = null, $utm_term = null, $utm_content = null, $utm_campaign = null)
    {
        if (isset($enable)) {
            $this->setEnable($enable);
        }
        if (isset($utm_source)) {
            $this->setCampaignSource($utm_source);
        }
        if (isset($utm_medium)) {
            $this->setCampaignMedium($utm_medium);
        }
        if (isset($utm_term)) {
            $this->setCampaignTerm($utm_term);
        }
        if (isset($utm_content)) {
            $this->setCampaignContent($utm_content);
        }
        if (isset($utm_campaign)) {
            $this->setCampaignName($utm_campaign);
        }
    }

    public function setEnable($enable)
    {
        if (!is_bool($enable)) {
            throw new TypeException('$enable must be of type bool.');
        }
        $this->enable = $enable;
    }

    public function getEnable()
    {
        return $this->enable;
    }

    public function setCampaignSource($utm_source)
    {
        if (!is_string($utm_source)) {
            throw new TypeException('$utm_source must be of type string.');
        }
        $this->utm_source = $utm_source;
    }

    public function getCampaignSource()
    {
        return $this->utm_source;
    }

    public function setCampaignMedium($utm_medium)
    {
        if (!is_string($utm_medium)) {
            throw new TypeException('$utm_medium must be of type string.');
        }
        $this->utm_medium = $utm_medium;
    }

    public function getCampaignMedium()
    {
        return $this->utm_medium;
    }

    public function setCampaignTerm($utm_term)
    {
        if (!is_string($utm_term)) {
            throw new TypeException('$utm_term must be of type string');
        }
        $this->utm_term = $utm_term;
    }

    public function getCampaignTerm()
    {
        return $this->utm_term;
    }

    public function setCampaignContent($utm_content)
    {
        if (!is_string($utm_content)) {
            throw new TypeException('$utm_content must be of type string.');
        }
        $this->utm_content = $utm_content;
    }

    public function getCampaignContent()
    {
        return $this->utm_content;
    }

    public function setCampaignName($utm_campaign)
    {
        if (!is_string($utm_campaign)) {
            throw new TypeException('$utm_campaign must be of type string.');
        }
        $this->utm_campaign = $utm_campaign;
    }

    public function getCampaignName()
    {
        return $this->utm_campaign;
    }

    public function jsonSerialize()
    {
        return array_filter(['enable' => $this->getEnable(), 'utm_source' => $this->getCampaignSource(), 'utm_medium' => $this->getCampaignMedium(), 'utm_term' => $this->getCampaignTerm(), 'utm_content' => $this->getCampaignContent(), 'utm_campaign' => $this->getCampaignName()], function ($value) {
            return $value !== null;
        }) ?: null;
    }
}
