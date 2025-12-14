<?php
/**
 * █ -------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                                                    2023-11-26 00:29:34
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules}\Sie\Controllers\Sie.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                                                                         consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ -------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ -------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.codehiggs.com
 * █ @Version 2.0.0 @since PHP 7, PHP 8
 * █ -------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ -------------------------------------------------------------------------------------------------------------------
 * █ Ninguno
 * █ -------------------------------------------------------------------------------------------------------------------
 **/

namespace App\Modules\Sie\Controllers;

use App\Controllers\ModuleController;

class Tools extends ModuleController
{


    public function __construct()
    {
        set_time_limit(0);
        ignore_user_abort(true);
        ini_set('memory_limit', '-1');
        ob_end_flush();
        ob_implicit_flush(true);

        parent::__construct();
        $this->module = 'App\Modules\Sie';
        helper($this->module . '\Helpers\Sie_helper');
        $this->prefix = 'sie-tools';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Tools';
    }

    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Tools\Home';
        return (view($this->viewer, $this->get_Array()));
    }


    public function enroller(string $rnd = "index", string $oid = null)
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-enroller";
        return (view($this->viewer, $this->get_Array()));
    }

    public function snies(string $rnd = "index", string $oid = null)
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-snies";
        return (view($this->viewer, $this->get_Array()));
    }

    public function certify(string $rnd = "index", string $oid = null)
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-snies";
        return (view($this->viewer, $this->get_Array()));
    }


    public function preenrollment(string $rnd = "index", string $oid = null)
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-preenrollment";
        return (view($this->viewer, $this->get_Array()));
    }

    public function preenrollments(string $rnd = "index", string $oid = null)
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-preenrollments";
        $this->component = $this->views . '\Tools\Preenrollments';
        return (view($this->viewer, $this->get_Array()));
    }

    public function training(string $option, string $oid = null)
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-training-{$option}";
        $this->component = $this->views . '\\Tools\\Training\\' . ucfirst($option);
        return (view($this->viewer, $this->get_Array()));
    }


    public function discounts(string $rnd = "index", string $oid = null)
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-discounts";
        return (view($this->viewer, $this->get_Array()));
    }

    public function importer(string $rnd = "index", string $oid = null)
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-importer";
        return (view($this->viewer, $this->get_Array()));
    }


    public function statuses(string $option, string $oid = null)
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-statuses-{$option}";
        $this->component = $this->views . '\\Tools\\Statuses\\' . ucfirst($option);
        return (view($this->viewer, $this->get_Array()));
    }


    public function progresspensummodule(string $option, string $oid = null)
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-progresspensummodule";
        $this->component = $this->views . '\\Tools\\ProgressPensumModule';
        return (view($this->viewer, $this->get_Array()));
    }

    public function community(string $option, string $oid = null)
    {
        $this->oid = null;
        $this->prefix = "{$this->prefix}-community";
        $this->component = $this->views . '\\Tools\\Community';
        return (view($this->viewer, $this->get_Array()));
    }


    public function users(string $option, string $oid = null)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-users-{$option}";
        $this->component = $this->views . "\\Tools\\Users";
        return (view($this->viewer, $this->get_Array()));
    }

    public function autoenrollment(string $option, string $oid = null)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-autoenrollment";
        $this->component = $this->views . "\\Tools\\Autoenrollment";
        return (view($this->viewer, $this->get_Array()));
    }

    public function moodle(string $option, string $oid = null)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-moodle-{$option}";
        $this->component = $this->views . "\\Tools\\Moodle";
        return (view($this->viewer, $this->get_Array()));
    }

    public function direct(string $option, string $oid = null)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-direct-{$option}";
        $this->component = $this->views . "\\Tools\\Direct";
        return (view($this->viewer, $this->get_Array()));
    }



}

?>