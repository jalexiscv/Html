<?php namespace App\Controllers;

use Higgs\Controller;

class QueryLog extends Controller
{
    public function index()
    {
        // Asegúrate de que la conexión a la base de datos esté cargada
        $db = \Config\Database::connect();

        // Ejecuta algunas operaciones de base de datos aquí, como consultas o actualizaciones
        // ...

        // Recupera la información de depuración de la conexión a la base de datos
        $debugInfo = $db->debug();

        // Extrae el registro de consultas de la información de depuración
        $queries = $debugInfo['queries'];

        // Muestra el registro de consultas en la vista
        return view('query_log', ['queries' => $queries]);
    }
}