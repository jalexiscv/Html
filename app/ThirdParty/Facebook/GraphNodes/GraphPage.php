<?php

namespace Facebook\GraphNodes;
class GraphPage extends GraphNode
{
    protected static $graphObjectMap = ['best_page' => '\Facebook\GraphNodes\GraphPage', 'global_brand_parent_page' => '\Facebook\GraphNodes\GraphPage', 'location' => '\Facebook\GraphNodes\GraphLocation', 'cover' => '\Facebook\GraphNodes\GraphCoverPhoto', 'picture' => '\Facebook\GraphNodes\GraphPicture',];

    public function getId()
    {
        return $this->getField('id');
    }

    public function getCategory()
    {
        return $this->getField('category');
    }

    public function getName()
    {
        return $this->getField('name');
    }

    public function getBestPage()
    {
        return $this->getField('best_page');
    }

    public function getGlobalBrandParentPage()
    {
        return $this->getField('global_brand_parent_page');
    }

    public function getLocation()
    {
        return $this->getField('location');
    }

    public function getCover()
    {
        return $this->getField('cover');
    }

    public function getPicture()
    {
        return $this->getField('picture');
    }

    public function getAccessToken()
    {
        return $this->getField('access_token');
    }

    public function getPerms()
    {
        return $this->getField('perms');
    }

    public function getFanCount()
    {
        return $this->getField('fan_count');
    }
}