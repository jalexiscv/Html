<?php


namespace App\Modules\Sie\Controllers;

use Higgs\API\ResponseTrait;
use Higgs\RESTful\ResourceController;

/**
 * Api
 */
class Documents extends ResourceController
{
    use ResponseTrait;

    public $namespace;
    protected $prefix;
    protected $module;
    protected $views;
    protected $viewer;
    protected $component;
    protected $oid;


    public function __construct()
    {
        helper('App\Helpers\Application');
    }

    /**
     * "Certificado de notas" en inglés se dice "transcript" o "academic transcript".
     * @param string $oid
     * @return array|false|mixed|string
     */
    public function certificate(string $oid)
    {
        $this->oid = $oid;
        if ($oid == "grade") {
            return (view("App\Modules\Sie\Views\Certifications\Transcript\index", $this->get_Array()));
        } elseif ($oid == "history") {
            return (view("App\Modules\Sie\Views\Certifications\History\index", $this->get_Array()));
        } else {
            echo("Seleccione un tipo de documento..");
        }

    }


    public function observations(string $options, string $oid)
    {
        $this->oid = $oid;
        if ($options == "individual") {
            return (view("App\Modules\Sie\Views\Observations\Reports\Individual\docx", $this->get_Array()));
        } elseif ($options == "grupal") {
            return (view("App\Modules\Sie\Views\Observations\Reports\Grupal\docx", $this->get_Array()));
        } else {
            echo("Seleccione un tipo de documento..");
        }
    }


    /**
     * Devuelve un array asociativo con las propiedades del controlador.
     *
     * Este método utiliza la función `get_object_vars` para obtener todas las propiedades
     * del objeto actual (controlador) y las devuelve como un array asociativo.
     * Las claves del array son los nombres de las propiedades y los valores son los valores de las propiedades.
     *
     * @return array Un array asociativo que contiene las propiedades del controlador.
     */
    public function get_Array(): array
    {
        return get_object_vars($this);
    }

}

?>