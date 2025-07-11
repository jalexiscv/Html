<?php

use Libraries\chromadb\ChromaDB;

require_once("ChromaDB.php");

$collection_name = 'conversations-test-additems';
$metadata = ['description' => 'This is a test collection'];


$chromadb = new ChromaDB();

// Crear una nueva colección con metadatos
$result = $chromadb->createCollection($collection_name, true, $metadata);
//echo(safe_dump($result));
$collection = $chromadb->getCollection($collection_name);
$collection_id = $collection['id'];
//echo(safe_dump($collection));
$result = $chromadb->addItems(collectionId: $collection_id, ids: ['documento-' . uniqid()], documents: ['texto del documento 1'], metadatas: [['title' => 'metadata1']], embeddings: [[0.1, 0.2, 0.3]]);
//$result = $chromadb->deleteItems(collectionId: $collection_id,ids: ['item1', 'item2']);
$count = $chromadb->countItems($collection_id);
//echo(safe_dump($count));
$item = $chromadb->getItems(collectionId: $collection_id, ids: ['documento-677c4227b248b'], include: ['documents', 'metadatas']);
//echo(safe_dump($item));


$queryitem = $chromadb->queryItems(
    collectionId: $collection_id,
    queryEmbeddings: [[0.1, 0.2, 0.3]],
    include: ['documents', 'metadatas', 'distances'],
    nResults: 5
);
echo(safe_dump($queryitem));


exit();


if ($result['status']) {
    foreach ($result['details']['collections'] as $collection) {
        echo "Collection: " . $collection['name'] . "\n";
    }
} else {
    echo "Error: " . $result['message'];
}

function safe_dump($mixed = null, $format = true)
{
    ob_start();
    var_dump($mixed);
    $content = ob_get_clean();
    if ($format) {
        $content = "<pre>" . htmlspecialchars($content, ENT_QUOTES | ENT_SUBSTITUTE) . "</pre>";
    }
    return $content;
}

?>