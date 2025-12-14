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

namespace App\Modules\Security\Controllers;

use App\Controllers\ModuleController;

class Session extends ModuleController
{


    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'security-session';
        $this->module = 'App\Modules\Security';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Security');
    }

    public function index()
    {
        $url = base_url('security/users/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function disconnect(string $rnd = null)
    {
        $this->authentication->logout();
        $url = base_url('/');
        return (redirect()->to($url));
    }

    public function logout(string $rnd = null)
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-logout";
        $this->component = $this->views . '\Session\Logout';
        return (view($this->viewer, $this->get_Array()));
    }

    public function signin(string $rnd = null)
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-signin";
        $this->component = $this->views . '\Session\Signin';
        return (view($this->viewer, $this->get_Array()));
    }

    public function signup(string $rnd = null)
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-signup";
        $this->component = $this->views . '\Session\Signup';
        return (view($this->viewer, $this->get_Array()));
    }

    public function resignin(string $token = null)
    {
        $this->oid = $token;
        $this->prefix = "{$this->prefix}-resignin";
        $this->component = $this->views . '\Session\Resignin';
        return (view($this->viewer, $this->get_Array()));
    }

    public function recovery(string $rnd = null)
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-recovery";
        $this->component = $this->views . '\Session\Recovery';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>