<?php
/*
 * Copyright (c) 2022. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Controllers;

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


    /**
     * @param string $format
     * @param string $rnd
     * @return \Higgs\HTTP\Response
     */
    public function countries(string $format, string $option, string $oid)
    {
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Views\Api\countries'), 200));
            } else {

            }
        } else {
            return ($this->failNotFound(lang("App.Api-Authentication-no-option")));
        }
    }

    public function regions(string $format, string $option, string $oid)
    {
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Views\Api\regions'), 200));
            } else {

            }
        } else {
            return ($this->failNotFound(lang("App.Api-Authentication-no-option")));
        }
    }

    public function cities(string $format, string $option, string $oid)
    {
        if ($format == "json") {
            if ($option == 'list') {
                return ($this->respond(view('App\Views\Api\cities'), 200));
            } else {

            }
        } else {
            return ($this->failNotFound(lang("App.Api-Authentication-no-option")));
        }
    }

    /*
     * c
     */
    public function theme(string $component, string $option, string $value)
    {
        if ($component == "mode") {
            if ($option == "update") {
                if ($value == "light" || $value == "dark") {
                    $authentication = service('authentication');
                    $authentication->set_ThemeMode("theme-{$value}");
                    //echo("{$component} - {$option} - {$value} <br>");
                    //echo($authentication->get_ThemeMode());
                    //print_r($_SESSION);
                    return (redirect()->to(base_url('/') . "?session=" . session_id()));
                } else {
                    return ($this->failNotFound("Theme Mode: Modo no valido"));
                }
            } else {
                return ($this->failNotFound(lang("App.Api-Authentication-no-option")));
            }
        } else {
            return ($this->failNotFound(c));
        }
    }


}

?>