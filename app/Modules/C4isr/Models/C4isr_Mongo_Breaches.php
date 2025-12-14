<?php

namespace App\Modules\C4isr\Models;

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
     * //$query = new MongoDB\Driver\Query($filtro, ['limit' => 10, 'offset' => 0]);
     * //$documents = $manager->executeQuery('c4isr.breaches', $query);
     * @param $limit
     * @param $offset
     * @return array|void
     */
    function findAll($limit = 10, $offset = 0, $filter = null)
    {
        try {
            if (!is_null($filter)) {
                $cursor = $this->collection->find($filter, ['limit' => $limit, 'offset' => $offset]);
            } else {
                $cursor = $this->collection->find([], ['limit' => $limit, 'offset' => $offset]);
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
}

?>