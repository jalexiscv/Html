<?php

namespace App\Controllers;

use Higgs\Controller;
use Config\Services;
use Throwable;

class Migrate extends Controller
{

    public function index()
    {
// Obtener el servicio de migraciones
        $migrations = \Config\Services::migrations();
        $modulesPath = APPPATH . 'Modules';
        $modules = scandir($modulesPath);

        try {
            foreach ($modules as $module) {
                if ($module === '.' || $module === '..') {
                    continue;
                }
                $migrations->setNamespace('App\Modules\\' . $module);// Set the namespace for the current module
                $migrations->latest();// Run the migrations for the current module
            }

            echo "Migraciones ejecutadas exitosamente para todos los módulos.";
        } catch (\Throwable $e) {
            echo "Error ejecutando las migraciones: " . $e->getMessage();// Manejar cualquier error que ocurra
        }
    }
}