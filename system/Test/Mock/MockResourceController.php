<?php

namespace Higgs\Test\Mock;

use Higgs\RESTful\ResourceController;

class MockResourceController extends ResourceController
{
    public function getModel()
    {
        return $this->model;
    }

    public function getModelName()
    {
        return $this->modelName;
    }

    public function getFormat()
    {
        return $this->format;
    }
}