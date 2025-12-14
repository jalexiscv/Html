<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Modules\C4isr\Controllers;

use Higgs\API\ResponseTrait;
use Higgs\RESTful\ResourceController;
use App\Libraries\Dates;


/**
 * Api
 */
class Api extends ResourceController
{

    use ResponseTrait;

    public function __construct()
    {
        header("Content-Type: text/json");
        helper('App\Helpers\Application');
        helper('App\Modules\Security\Helpers\Security');
    }

    public function index()
    {
        $data = array("message" => "Api Online!");
        return $this->respond($data);
    }

    // all users

    /**
     * Retorna el listado de caracterizaciones
     */
    public function breaches(string $format, string $option, string $oid)
    {
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\C4isr\Views\Breaches\List\json.php', $data), 200));
            } else {

            }
        } else {
            return ($this->failNotFound(lang("App.Api-breaches-no-option")));
        }
    }

    public function intrusions(string $format, string $option, string $oid)
    {
        set_time_limit(0);
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\C4isr\Views\Intrusions\List\json.php', $data), 200));
            } elseif ($option == 'import') {
                return ($this->respond(view('App\Modules\C4isr\Views\Intrusions\Import\json.php', $data), 200));
            } else {
                return ($this->failNotFound(lang("App.intrusions-unknow-option")));
            }
        } else {
            return ($this->failNotFound(lang("App.Api-breaches-no-option")));
        }
    }

    public function mails(string $format, string $option, string $oid)
    {
        set_time_limit(0);
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\C4isr\Views\Mails\List\json.php', $data), 200));
            } elseif ($option == 'import') {
                return ($this->respond(view('App\Modules\C4isr\Views\Mails\Import\json.php', $data), 200));
            } else {
                return ($this->failNotFound(lang("App.intrusions-unknow-option")));
            }
        } else {
            return ($this->failNotFound(lang("App.Api-breaches-no-option")));
        }
    }

    public function incidents(string $format, string $option, string $oid)
    {
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\C4isr\Views\Incidents\List\json.php', $data), 200));
            } elseif ($option == 'create') {
                return ($this->respond(view('App\Modules\C4isr\Views\Incidents\Create\json.php', $data), 200));
            } else {
                return ($this->failNotFound(lang("App.intrusions-unknow-option")));
            }
        } else {
            return ($this->failNotFound(lang("App.Api-breaches-no-option")));
        }
    }


    public function profiles(string $format, string $option, string $oid)
    {
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Modules\C4isr\Views\Profiles\List\json.php', $data), 200));
            }
        } else {
            return ($this->failNotFound(lang("App.Api-breaches-no-option")));
        }
    }


    public function vulnerabilities(string $format, string $option, string $oid)
    {
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'keys') {
                return ($this->respond(view('App\Modules\C4isr\Views\Vulnerabilities\Api\keys.php', $data), 200));
            }
        } else {
            return ($this->failNotFound(lang("App.Api-breaches-no-option")));
        }
    }


    public function darkweb(string $format, string $option, string $oid)
    {
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                return (view('App\Modules\C4isr\Views\Darkweb\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("App.Api-breaches-no-option")));
        }
    }


    public function shodan($oid)
    {

    }


}

?>