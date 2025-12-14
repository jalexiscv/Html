<?php

namespace Facebook\GraphNodes;
class GraphApplication extends GraphNode
{
    public function getId()
    {
        return $this->getField('id');
    }
}