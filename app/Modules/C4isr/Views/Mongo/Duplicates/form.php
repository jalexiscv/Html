<?php
require_once(APPPATH . 'ThirdParty/Mongo/autoload.php');

//el proposito de este programa es importar uno a uno los archivos cargados en el public import
use App\Libraries\Mongo;

$mosints = model("App\Modules\C4isr\Models\C4isr_Mongo_Osints");

$dates = service("dates");
$strings = service("strings");


// Conexión a la base de datos de MongoDB
$client = new MongoDB\Client('mongodb://localhost:27017');

// Seleccionar la base de datos y la colección que deseas buscar duplicados
$collection = $client->c4isr->breaches;

// Crear una consulta para buscar documentos duplicados
$pipeline = [
    [
        '$group' => [
            '_id' => '$username',
            'count' => ['$sum' => 1]
        ]
    ],
    [
        '$match' => [
            'count' => ['$gt' => 1]
        ]
    ],
    [
        '$limit' => 1
    ]
];

// Ejecutar la consulta y obtener los resultados
$result = $collection->aggregate($pipeline);

// Recorrer los resultados y mostrar los nombres de usuario duplicados
foreach ($result as $doc) {
    echo 'Usuario: ' . $doc['_id'] . ', cantidad de duplicados: ' . $doc['count'] . '<br>';
}


$c = '';

/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
echo($c);
?>