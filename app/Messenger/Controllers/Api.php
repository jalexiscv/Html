<?php
/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */

namespace app\Messenger\Controllers;

use App\Modules\Messenger\Controllers\codigo;
use App\Modules\Messenger\Controllers\messengeruse App\Modules\Messenger\Controllers\messengeruse App\Modules\Messenger\Controllers\valor;use Higgs\API\ResponseTrait;
use Higgs\RESTful\ResourceController;

/**
 * Api
 */
class Api extends ResourceController
{

    use ResponseTrait;

    public $prefix;
    public $namespace;
    public $request;
    protected $authentication;
    protected $helpers = [];
    protected $oid;
    protected $component;
    protected $model_users;
    protected $model_fields;

    public function __construct()
    {
        $this->authentication = service('authentication');
        $this->dates = service('Dates');
        $this->request = service('request');

        $this->prefix = 'messenger-api';
        $this->module = 'App\Modules\Messenger';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Api';
        $this->request = service("request");

    }

    public function index($view = "home")
    {
        return ("Api");
    }

    /**
     * Este método se utilizará para enviar mensajes y archivos entre y hacia los usuarios
     * @param $view messenger-api-send-message | messenger-api-send-file
     * @param $id valor aleatorio para garantizar el refresco de la transacción
     * @return string
     */
    public function send($view, $rnd)
    {
        $this->data = array("controller" => $this, "view" => "{$this->prefix}-send-{$view}", "id" => $rnd);
        return (view("{$this->views}\ajax", $this->data));
    }

    /**
     * Retorna la conversación entre el usuario activo y el indicado.
     * @param $user codigo del usuario
     * @param $id valor aleatorio para garantizar el refresco de la transacción
     * @return string
     */
    public function conversation($user, $rnd)
    {
        $this->data = array("controller" => $this, "view" => "{$this->prefix}-conversation", "id" => $user);
        return (view("{$this->views}\ajax", $this->data));
    }


    public function discussion($group, $rnd)
    {
        $this->data = array("controller" => $this, "view" => "{$this->prefix}-discussion", "group" => $group);
        return (view("{$this->views}\ajax", $this->data));
    }


    public function uploaders(string $format, string $option)
    {
        $this->data = array(
            "controller" => $this,
            "view" => "{$this->prefix}-uploaders",
            "format" => $format,
            "option" => $option
        );
        return (view("{$this->views}\ajax", $this->data));
    }


    public function json($view, $id)
    {
        $this->data = array("controller" => $this, "view" => "{$this->prefix}-{$view}", "id" => $id);
        return (view("{$this->views}\ajax", $this->data));
    }


    /**
     * @param string $format
     * @param string $option
     * @param string $oid
     * @return \Higgs\HTTP\Response|void
     */
    public function messages(string $format, string $option, string $oid, string $rnd = null)
    {
        header("Content-Type: text/json");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Messenger\Views\Messages\List\json', $data), 200));
            } else {

            }
        } else {
            return ($this->failNotFound(lang("App.Api-Authentication-no-option")));
        }
    }


    /**
     * @param string $format
     * @param string $option
     * @param string $oid
     * @return \Higgs\HTTP\Response|void
     */
    public function members(string $format, string $option, string $oid, string $rnd = null)
    {
        header("Content-Type: text/json");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\Messenger\Views\Members\List\json', $data), 200));
            } elseif ($option == 'update') {
                return ($this->respond(view('App\Modules\Messenger\Views\Members\Api\check', $data), 200));
            } else {

            }
        } else {
            return ($this->failNotFound(lang("App.Api-Authentication-no-option")));
        }
    }


}

?>