<?php

namespace Facebook\GraphNodes;
class GraphLocation extends GraphNode
{
    public function getStreet()
    {
        return $this->getField('street');
    }

    public function getCity()
    {
        return $this->getField('city');
    }

    public function getState()
    {
        return $this->getField('state');
    }

    public function getCountry()
    {
        return $this->getField('country');
    }

    public function getZip()
    {
        return $this->getField('zip');
    }

    public function getLatitude()
    {
        return $this->getField('latitude');
    }

    public function getLongitude()
    {
        return $this->getField('longitude');
    }
}