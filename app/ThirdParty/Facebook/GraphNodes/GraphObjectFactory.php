<?php

namespace Facebook\GraphNodes;

use Facebook\Exceptions\FacebookSDKException;

class GraphObjectFactory extends GraphNodeFactory
{
    const BASE_GRAPH_NODE_CLASS = '\Facebook\GraphNodes\GraphObject';
    const BASE_GRAPH_EDGE_CLASS = '\Facebook\GraphNodes\GraphList';

    public function makeGraphObject($subclassName = null)
    {
        return $this->makeGraphNode($subclassName);
    }

    public function makeGraphEvent()
    {
        return $this->makeGraphNode(static::BASE_GRAPH_OBJECT_PREFIX . 'GraphEvent');
    }

    public function makeGraphList($subclassName = null, $auto_prefix = true)
    {
        return $this->makeGraphEdge($subclassName, $auto_prefix);
    }
}