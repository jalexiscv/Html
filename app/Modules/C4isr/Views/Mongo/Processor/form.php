<?php
require_once(APPPATH . 'ThirdParty/Mongo/autoload.php');

//el proposito de este programa es importar uno a uno los archivos cargados en el public import
use App\Libraries\Mongo;

$mosints = model("App\Modules\C4isr\Models\C4isr_Mongo_Osints");

$dates = service("dates");
$strings = service("strings");

$c = "--DATABASES<br>";
$client = new MongoDB\Client("mongodb://localhost:27017");
$databases = $client->listDatabases();
foreach ($databases as $database) {
    $c .= $database->getName() . "<br>\n";
}


$path = ROOTPATH . "public/imports";
$dir = opendir($path);
$files = array();
while ($current = readdir($dir)) {
    if ($current != "." && $current != "..") {
        if (is_dir($path . $current)) {
            showFiles($path . $current . '/');
        } else {
            $files[] = $current;
        }
    }
}


$mongo = new Mongo('default');

$c .= '<h2>' . $path . '</h2>';
$c .= '<ul>';
for ($i = 0; $i < 1; $i++) {
    $uri = ROOTPATH . "public/imports/{$files[$i]}";
    $c .= '<li>' . $uri . "</li>";
    $file = fopen($uri, "r");

    if ($file) {
        $lote = array();
        while (!feof($file)) {
            $line = fgets($file);
            $data = explode(':', $line);
            $d = array(
                "phone" => @$data[0],
                "fid" => @$data[1],
                "firstname" => @$data[2],
                "lastname" => @$data[3],
                "sex" => @$data[4],
                "region" => @$data[5],
                "town" => @$data[6],
                "marital" => @$data[7],
                "job" => @$data[8],
                "birthday" => @$data[9],
                "created_at" => @$dates->get_DateTime(),
            );
            $c .= $mosints->insert($d);
            //$c .= $line . "<br>";
            //array_push($lote, $d);
            //flush();
            //ob_flush();
        }
        fclose($file);
        if (file_exists($uri)) {
            if (unlink($uri)) {
                $c .= "El archivo ha sido eliminado correctamente.";
            } else {
                $c .= "No se ha podido eliminar el archivo.";
            }
        } else {
            $c .= "El archivo no existe en la ruta especificada.";
        }
        //print_r($lote);
        //$create = $model->insertBatch($lote);

    } else {
        $c .= "No se pudo abrir el archivo.";
    }

}
$c .= '</ul>';


//[Mongo-Query]
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
$filtro = [];
$query = new MongoDB\Driver\Query($filtro, ['limit' => 25, 'offset' => 0]);
$documents = $manager->executeQuery('c4isr.Osints', $query);


//[Total-Count]
$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->c4isr->Osints;
$total = $collection->CountDocuments($filtro);


//$total = 0;
//[Build]
$c .= '<table class="table table-bordered w-100">';

$count = 0;
foreach ($documents as $document) {
    $count++;
    $c .= '<tr>';
    $c .= '<td>' . $count . '</td>';
    $c .= '<td>' . @$document->phone . '</td>';
    $c .= '<td>' . @$document->fid . '</td>';
    $c .= '</tr>';
}
$c .= '</table>';

$c .= '<b>Total: </b>' . $total;


$c .= '<script>window.onload = function() {location.reload();}</script>';
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
echo($c);
?>