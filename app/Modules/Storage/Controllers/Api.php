<?php

namespace App\Modules\Storage\Controllers;

use Higgs\API\ResponseTrait;
use Higgs\RESTful\ResourceController;

/**
 * Api
 */
class Api extends ResourceController
{

    use ResponseTrait;

    public $prefix;
    public $namespace;

    public function __construct()
    {
        header("Content-Type: text/json");
        helper('App\Helpers\Application');
        helper('App\Modules\Storage\Helpers\Storage');
        $this->prefix = 'storage-api';
        $this->namespace = 'App\Modules\Storage\Views\Api';

    }

    // all users
    public function index()
    {
        $data = array("message" => "Api Online!");
        return $this->respond($data);
    }

    /**
     * Este metodo alamacena y registra un unico archivo enviado
     * @param mixed $option
     * @return void
     */

    public function single($rnd)
    {
        $data = [
            'rnd' => $rnd,
            'name' => $this->request->getVar('name'),
            'size' => $this->request->getVar('size')
        ];
        return (view("{$this->namespace}\single", $data));
    }

    /**
     * La transferencia de archivos grandes es una tarea común en muchos ámbitos, desde la industria hasta el usuario
     * final. Sin embargo, la transferencia de archivos grandes puede ser una tarea complicada, especialmente cuando se
     * trata de transferir archivos a través de la red. Para abordar este problema, una solución común es dividir el
     * archivo en "chunks" o fragmentos más pequeños.
     * https://www.cgine.com/social/semantic/importancia-utilizar-chunks-transferencia-archivos-grandes-3a-eficiencia-2c-seguridad-y-recuperaci-c3-b3n-6418d76c221cb.html
     * @param $rnd
     * @return array|false|mixed|string
     */
    public function chunks($oid)
    {
        $data = [
            'oid' => $oid,
            //'name' => $this->request->getVar('name'),
            //'size' => $this->request->getVar('size')
        ];
        return (view("{$this->namespace}\chunks", $data));
    }

    /**
     * Retorna el listado de archivos asociados a un objeto
     * @param mixed $option
     * @return void
     */

    public function list($object)
    {
        $data = [
            'object' => $object
        ];
        return (view("{$this->namespace}\list", $data));
    }


    public function create()
    {
        $model = new EmployeeModel();
        $data = [
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
        ];
        $model->insert($data);
        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Employee created successfully'
            ]
        ];
        return $this->respondCreated($response);
    }


    // delete
    public function delete($oid = null)
    {
        $model = new EmployeeModel();
        $data = $model->where('id', $oid)->delete($oid);
        if ($data) {
            $model->delete($oid);
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => 'Employee successfully deleted'
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('No employee found');
        }
    }


    /**
     * @param string $format
     * @param string $rnd
     * @return \Higgs\HTTP\Response
     */
    public function attachments(string $format, string $rnd)
    {
        if ($format == "json") {
            return (view('App\Modules\Storage\Views\Attachments\List\json'));
        } else {
            return ($this->failNotFound(lang("App.Api-attachments-no-option")));
        }
    }

    /*
     * Retorna el listado de los archivos asociados a un objeto en formato JSON
     *
     */
    public function files(string $format, string $object)
    {
        $data = array(
            "oid" => $object,
        );
        if ($format == "json") {
            return (view('App\Modules\Storage\Views\Api\files', $data));
        } elseif ($format == "delete") {
            return (view('App\Modules\Storage\Views\Api\delete', $data));
        } else {
            return ("Formato desconocido!");
        }
    }

    /**
     * Recibe una tabla html y la convierte en un archivo excel
     * @param string $format
     * @param string $option
     * @param string $oid
     * @return array|false|mixed|string
     */
    public function excel(string $format, string $option, string $oid){
        ini_set('memory_limit', '512M');
        return(view("App\Modules\Sie\Views\Api\Excel\index.php",array("format"=>$format,"option"=>$option,"oid"=>$oid)));
    }


}

?>