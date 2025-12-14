<?php
/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */

namespace App\Modules\Databreaches\Models;

use App\Libraries\Mongo;

/**
 *
 * In the BooksModel class methods, we're using collection methods from the MongoDB PHP driver API to fetch, insert,
 * update, and delete books:
 * The find() method fetches a $limit number of documents from the books collection.
 * The findOne() method fetches a single document from the books collection based on the _id field.
 * The insertOne() method inserts a single document into the books collection.
 * The updateOne() method updates a single document in the books collection based on the _id field.
 * The deleteOne() method deletes a single document from the books collection based on the _id field.
 *
 * $mdatabreaches = model("App\Modules\Databreaches\Models\Databreaches_Mongo");
 * $mdatabreaches->insert(array(
 * 'timestamp' => time(),
 * 'name' => 'Jose Alexis Correa Valencia',
 * 'email' => 'jalexiscv@gmail.com'
 * )
 * );
 *
 *
 *
 */
class C4isr_Mongo_Breaches
{
    private $collection;

    function __construct()
    {
        $connection = new Mongo();
        $database = $connection->getDatabase();
        $this->collection = $database->breaches;
    }

    /**
     * //$mongo = new Mongo('default');
     * //[Mongo-Query]
     * //$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
     * //$filtro = [];
     * //$filter = ['0' => new MongoDB\BSON\Regex('ja', 'i')];
     * //$query = new MongoDB\Driver\Query($filtro, ['limit' => 10, 'offset' => 0]);
     * //$documents = $manager->executeQuery('c4isr.breaches', $query);
     * @param $limit
     * @param $offset
     * @return array|void
     */
    function findAll($limit = 10, $offset = 0, $filter = null)
    {
        try {
            $options = ['limit' => $limit, 'offset' => $offset, 'maxTimeMS' => (60000) * 10]; //60000 = 60 segundos
            if (!is_null($filter)) {
                $cursor = $this->collection->find($filter, $options);
            } else {
                $cursor = $this->collection->find([], $options);
            }
            $cursor = $cursor->toArray();
            return ($cursor);
        } catch (\MongoDB\Exception\RuntimeException $ex) {
            show_error('Error while fetching books: ' . $ex->getMessage(), 500);
        }
    }

    function find($id)
    {
        try {
            $book = $this->collection->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);

            return $book;
        } catch (\MongoDB\Exception\RuntimeException $ex) {
            show_error('Error while fetching book with ID: ' . $id . $ex->getMessage(), 500);
        }
    }

    function insert($data)
    {
        try {
            $insertOneResult = $this->collection->insertOne($data);

            if ($insertOneResult->getInsertedCount() == 1) {
                return ($insertOneResult->getInsertedId());
            }

            return false;
        } catch (\MongoDB\Exception\RuntimeException $ex) {
            show_error('Error while creating a book: ' . $ex->getMessage(), 500);
        }
    }

    function update($id, $title, $author, $pagesRead)
    {
        try {
            $result = $this->collection->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectId($id)],
                ['$set' => [
                    'title' => $title,
                    'author' => $author,
                    'pagesRead' => $pagesRead,
                ]]
            );

            if ($result->getModifiedCount()) {
                return true;
            }

            return false;
        } catch (\MongoDB\Exception\RuntimeException $ex) {
            show_error('Error while updating a book with ID: ' . $id . $ex->getMessage(), 500);
        }
    }

    function delete($id)
    {
        try {
            $result = $this->collection->deleteOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);
            if ($result->getDeletedCount() == 1) {
                return (true);
            }
            return (false);
        } catch (\MongoDB\Exception\RuntimeException $ex) {
            show_error('Error while deleting a book with ID: ' . $id . $ex->getMessage(), 500);
        }
    }

    function count()
    {
        try {
            $count = $this->collection->countDocuments([]);
            return ($count);
        } catch (\MongoDB\Exception\RuntimeException $ex) {
            show_error('Error while counting books: ' . $ex->getMessage(), 500);
        }
    }
}

?>