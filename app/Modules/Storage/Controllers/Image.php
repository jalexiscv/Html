<?php

namespace App\Modules\Storage\Controllers;

use App\Controllers\BaseController;

class Image extends BaseController
{

    public $prefix;
    public $namespace;

    public function __construct()
    {
        helper('App\Modules\Storage\Helpers\Storage');
        $this->prefix = 'storage-image';
        $this->namespace = 'App\Modules\Storage';
    }

    public function index($id)
    {
        $data = array("authentication" => $this->authentication, "view" => "{$this->prefix}-home", "id" => $id);
        $body = view("{$this->namespace}\Views\Image\index", $data);
        $this->response->setHeader("Content-Type", "image/jpeg");
        $this->response->setStatusCode("200");
        $this->response->setCache(array("max-age" => "60"));
        $this->response->setBody($body);
        $this->response->send();
    }

    // Retorna una vista miniatura de una imagen
    public function thumbnail($id, $alias)
    {
        $data = array("authentication" => $this->authentication, "view" => "{$this->prefix}-home", "id" => strtoupper($id));
        $body = view($this->namespace . '\Views\Image\thumbnail', $data);
        $this->response->setHeader("Content-Type", "image/jpg");
        $this->response->removeHeader('Cache-Control');
        $this->response->removeHeader('Pragma');
        $this->response->setHeader("Cache-Control", "public, max-age=604800, immutable");
        $this->response->setStatusCode("200");
        $this->response->setBody($body);
        $this->response->send();
    }


    // Retorna una vista miniatura de una imagen
    public function single($id, $alias)
    {
        $data = array("authentication" => $this->authentication, "view" => "{$this->prefix}-single", "id" => strtoupper($id));
        $body = view($this->namespace . '\Views\Image\single', $data);
        $this->response->setHeader("Content-Type", "image/jpg");
        //$this->response->setHeader("Content-Type", "text/html");
        $this->response->removeHeader('Cache-Control');
        $this->response->removeHeader('Pragma');
        $this->response->setHeader("Cache-Control", "public, max-age=604800, immutable");
        $this->response->setStatusCode("200");
        $this->response->setBody($body);
        $this->response->send();
    }


    public function avatar($id, $alias)
    {
        $cache_key = APPNODE . '_' . '_' . str_replace('\\', '_', get_class($this)) . '_' . $id;
        if (!$body = cache($cache_key)) {
            $data = array(
                "authentication" => $this->authentication,
                "view" => "{$this->prefix}-avatar",
                "id" => strtoupper($id)
            );
            $body = view($this->namespace . '\Views\Image\avatar', $data);
            cache()->save($cache_key, $body, 60);
        }
        $this->response->setHeader("Content-Type", "image/jpg");
        $this->response->setCache(array("max-age" => "600"));
        $this->response->setStatusCode("200");
        $this->response->setBody($body);
        $this->response->send();
    }


}

?>