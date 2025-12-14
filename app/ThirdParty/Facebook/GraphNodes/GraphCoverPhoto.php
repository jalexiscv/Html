<?php

namespace Facebook\GraphNodes;
class GraphCoverPhoto extends GraphNode
{
    public function getId()
    {
        return $this->getField('id');
    }

    public function getSource()
    {
        return $this->getField('source');
    }

    public function getOffsetX()
    {
        return $this->getField('offset_x');
    }

    public function getOffsetY()
    {
        return $this->getField('offset_y');
    }
}