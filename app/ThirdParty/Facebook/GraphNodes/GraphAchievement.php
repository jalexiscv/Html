<?php

namespace Facebook\GraphNodes;

use DateTime;

class GraphAchievement extends GraphNode
{
    protected static $graphObjectMap = ['from' => '\Facebook\GraphNodes\GraphUser', 'application' => '\Facebook\GraphNodes\GraphApplication',];

    public function getId()
    {
        return $this->getField('id');
    }

    public function getFrom()
    {
        return $this->getField('from');
    }

    public function getPublishTime()
    {
        return $this->getField('publish_time');
    }

    public function getApplication()
    {
        return $this->getField('application');
    }

    public function getData()
    {
        return $this->getField('data');
    }

    public function getType()
    {
        return 'game.achievement';
    }

    public function isNoFeedStory()
    {
        return $this->getField('no_feed_story');
    }
}