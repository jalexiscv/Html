<?php

namespace Facebook\GraphNodes;
class GraphPicture extends GraphNode
{
    public function isSilhouette()
    {
        return $this->getField('is_silhouette');
    }

    public function getUrl()
    {
        return $this->getField('url');
    }

    public function getWidth()
    {
        return $this->getField('width');
    }

    public function getHeight()
    {
        return $this->getField('height');
    }
}