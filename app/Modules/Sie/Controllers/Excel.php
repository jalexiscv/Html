<?php

namespace App\Modules\Sie\Controllers;


use Higgs\Controller;

//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
//use PhpOffice\PhpSpreadsheet\Style\Fill;
//use DOMDocument;

class Excel extends Controller
{
    private $prefix;
    private $module;
    private $views;
    private $viewer;

    public function __construct()
    {
        $this->prefix = 'sie-excels';
        $this->module = 'App\Modules\Sie';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        helper($this->module . '\Helpers\Sie_Excel_helper');
    }

    // all users
    public function preenrollments($oid)
    {
        return (view("App\Modules\Sie\Views\Excels\preenrollments"));
    }


    public function registrations($oid)
    {
        return (view("App\Modules\Sie\Views\Excels\Reports\Registrations"));
    }


}
