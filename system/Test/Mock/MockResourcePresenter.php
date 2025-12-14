<?php

namespace Higgs\Test\Mock;

use Higgs\API\ResponseTrait;
use Higgs\RESTful\ResourcePresenter;

class MockResourcePresenter extends ResourcePresenter
{
    use ResponseTrait;

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