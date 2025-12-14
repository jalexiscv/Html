<?php

namespace App\Modules\Plans\Controllers;

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-02-03 16:17:40
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Plans\Controllers\_Plans.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @var object $parent
 * █ @var object $authentication
 * █ @var object $request
 * █ @var object $dates
 * █ @var string $component
 * █ @var string $view
 * █ @var string $oid
 * █ @var string $views
 * █ @var string $prefix
 * █ @var array $data
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/

use App\Controllers\ModuleController;
use Higgs\HTTP\RedirectResponse;

/**
 *
 */
class Plans extends ModuleController
{

    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'plans-plans';
        $this->module = 'App\Modules\Plans';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Plans');
    }

    /**
     *
     * @return RedirectResponse
     */
    public function index(): RedirectResponse
    {
        $url = base_url('plans/plans/home/' . lpk());
        return (redirect()->to($url));
    }

    /**
     * @param string $rnd
     * @return array|false|mixed|string
     */
    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "$this->prefix-home";
        $this->component = $this->views . '\Plans\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    /**
     * @param string $oid
     * @return array|false|mixed|string
     */
    public function view(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "$this->prefix-view";
        $this->component = $this->views . '\Plans\View';
        return (view($this->viewer, $this->get_Array()));
    }

    public function list(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "$this->prefix-list";
        $this->component = $this->views . '\Plans\List';
        return (view($this->viewer, $this->get_Array()));
    }

    public function create(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "$this->prefix-create";
        $this->component = $this->views . '\Plans\Create';
        return (view($this->viewer, $this->get_Array()));
    }

    public function edit(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "$this->prefix-edit";
        $this->component = $this->views . '\Plans\Edit';
        return (view($this->viewer, $this->get_Array()));
    }

    public function delete(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "$this->prefix-delete";
        $this->component = $this->views . '\Plans\Delete';
        return (view($this->viewer, $this->get_Array()));
    }

    public function details(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "$this->prefix-details";
        $this->component = $this->views . '\Plans\Details';
        return (view($this->viewer, $this->get_Array()));
    }

    public function team(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "$this->prefix-team";
        $this->component = $this->views . '\Plans\Team';
        return (view($this->viewer, $this->get_Array()));
    }

    public function causes(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "$this->prefix-causes";
        $this->component = $this->views . '\Plans\Causes';
        return (view($this->viewer, $this->get_Array()));
    }

    public function formulation(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "$this->prefix-formulation";
        $this->component = $this->views . '\Plans\Formulation';
        return (view($this->viewer, $this->get_Array()));
    }

    public function actions(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "$this->prefix-actions";
        $this->component = $this->views . '\Plans\Actions';
        return (view($this->viewer, $this->get_Array()));
    }


    public function approval(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "$this->prefix-approval";
        $this->component = $this->views . '\Plans\Approval';
        return (view($this->viewer, $this->get_Array()));
    }

    public function approve(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "$this->prefix-approve";
        $this->component = $this->views . '\Plans\Approve';
        return (view($this->viewer, $this->get_Array()));
    }

    public function evaluate(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "$this->prefix-evaluate";
        $this->component = $this->views . '\Plans\Evaluate';
        return (view($this->viewer, $this->get_Array()));
    }


    public function evaluation(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "$this->prefix-evaluation";
        $this->component = $this->views . '\Plans\Evaluation';
        return (view($this->viewer, $this->get_Array()));
    }


    public function risks(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "$this->prefix-risks";
        $this->component = $this->views . '\Plans\Risks';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>