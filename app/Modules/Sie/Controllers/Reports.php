<?php

namespace App\Modules\Sie\Controllers;

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-04-30 03:13:11
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Controllers\_Products.php]
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
 * █ @var object $parent Trasferido desde el controlador
 * █ @var object $authentication Trasferido desde el controlador
 * █ @var object $request Trasferido desde el controlador
 * █ @var object $dates Trasferido desde el controlador
 * █ @var string $component Trasferido desde el controlador
 * █ @var string $view Trasferido desde el controlador
 * █ @var string $oid Trasferido desde el controlador
 * █ @var string $views Trasferido desde el controlador
 * █ @var string $prefix Trasferido desde el controlador
 * █ @var array $data Trasferido desde el controlador
 * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/

use App\Controllers\ModuleController;

class Reports extends ModuleController
{

    //[Sie/Config/Routes]


    public function __construct()
    {
        parent::__construct();
        $this->prefix = 'sie-reports';
        $this->module = 'App\Modules\Sie';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Sie_helper');
    }

    public function index()
    {
        $url = base_url('sie/reports/home/' . lpk());
        return (redirect()->to($url));
    }


    public function home(string $rnd)
    {
        $this->oid = $rnd;
        $this->prefix = "{$this->prefix}-home";
        $this->component = $this->views . '\Reports\Home';
        return (view($this->viewer, $this->get_Array()));
    }

    public function admissions(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-admissions";
        $this->component = $this->views . '\Reports\Admissions';
        return (view($this->viewer, $this->get_Array()));
    }

    public function evalteachers(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-evalteachers";
        $this->component = $this->views . '\Reports\Evalteachers';
        return (view($this->viewer, $this->get_Array()));
    }


    public function preenrollments(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-preenrollments";
        $this->component = $this->views . '\Reports\Preenrollments';
        return (view($this->viewer, $this->get_Array()));
    }

    public function teachers(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-teachers";
        $this->component = $this->views . '\Reports\Teachers';
        return (view($this->viewer, $this->get_Array()));
    }




    public function registrations(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-registrations";
        $this->component = $this->views . '\Reports\Registrations';
        return (view($this->viewer, $this->get_Array()));
    }

    public function programs(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-programs";
        $this->component = $this->views . '\Reports\Programs';
        return (view($this->viewer, $this->get_Array()));
    }

    public function biller(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-biller";
        $this->component = $this->views . '\Reports\Biller';
        return (view($this->viewer, $this->get_Array()));
    }

    public function humanresources(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-humanresources-{$oid}";
        $this->component = $this->views . '\Reports\HumanResources';
        return (view($this->viewer, $this->get_Array()));
    }

    public function population(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-population-{$oid}";
        $this->component = $this->views . '\Reports\Population';
        return (view($this->viewer, $this->get_Array()));
    }

    public function control(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-control-{$oid}";
        $this->component = $this->views . '\Reports\Control';
        return (view($this->viewer, $this->get_Array()));
    }


    public function projected(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-projected-{$oid}";
        $this->component = $this->views . '\Reports\Projected';
        return (view($this->viewer, $this->get_Array()));
    }


    public function snies(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-snies-{$oid}";
        $this->component = $this->views . '\Reports\Snies';
        return (view($this->viewer, $this->get_Array()));
    }

    /**
     * Generates a view for enrolled reports.
     * @param string $oid The unique identifier used to process enrolled reports.
     * @return mixed Returns the rendered view for enrolled reports.
     */
    public function enrolleds(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-enrolleds";
        $this->component = $this->views . '\Reports\Enrolleds';
        return (view($this->viewer, $this->get_Array()));
    }

    public function enrolledcourses(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-enrolledcourses";
        $this->component = $this->views . '\Reports\Snies\EnrolledCourses';
        return (view($this->viewer, $this->get_Array()));
    }

    public function participants(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-participants";
        if ($oid == "students") {
            $this->component = $this->views . '\Reports\Participants\Students';
        } else {
            $this->component = $this->views . '\Reports\Participants\Others';
        }
        return (view($this->viewer, $this->get_Array()));
    }

    public function registereds(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-registereds";
        $this->component = $this->views . '\Reports\Snies\Registereds';
        return (view($this->viewer, $this->get_Array()));
    }

    public function registeredslistregistereds(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-registeredslistregistereds";
        $this->component = $this->views . '\Reports\Snies\RegisteredsListRegistereds';
        return (view($this->viewer, $this->get_Array()));
    }

    public function firstyear(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-firstyear";
        $this->component = $this->views . '\Reports\Snies\FirstYear';
        return (view($this->viewer, $this->get_Array()));
    }

    public function coverage(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-coverage";
        $this->component = $this->views . '\Reports\Snies\Coverage';
        return (view($this->viewer, $this->get_Array()));
    }

    public function courses(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-courses-{$oid}";
        $this->component = $this->views . '\Courses\Reports';
        return (view($this->viewer, $this->get_Array()));
    }


    public function invoicing(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-invoicing";
        $this->component = $this->views . '\Reports\Invoicing';
        return (view($this->viewer, $this->get_Array()));
    }


    public function statistics(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-statistics-{$oid}";
        $this->component = $this->views . '\Reports\Statistics';
        return (view($this->viewer, $this->get_Array()));
    }

    public function observations(string $oid)
    {
        $this->oid = $oid;
        $this->prefix = "{$this->prefix}-observations-{$oid}";
        $this->component = $this->views . '\Observations\Reports\General';
        return (view($this->viewer, $this->get_Array()));
    }


}

?>

