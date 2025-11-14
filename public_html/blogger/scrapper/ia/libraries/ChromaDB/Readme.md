## 1. Crear una nueva colección con metadatos

```php
$collection_name = 'my_collection';
$metadata = ['description' => 'This is a test collection'];
$result = $chromadb->createCollection($collection_name, true, $metadata);

if (isset($result['error'])) {
echo "Error: " . $result['error'] . "\n";
if (isset($result['details'])) {
echo "Details: " . json_encode($result['details']) . "\n";
}
} else {
echo "Collection created successfully:\n";
echo "Status: " . $result['status'] . "\n";
echo "Response: " . json_encode($result['response']) . "\n";
}
```

## 2. Elimina colección con metadatos

```php
// Inicializar el cliente
$chroma = new ChromaDBClient(
    host: '34.133.165.149',
    port: '32768',
    token: 'test-token-chroma-local-dev'
);

// Eliminar una colección
if ($chromadb->deleteCollection('test-collection-chroma-local-dev')) {
    echo "Colección eliminada exitosamente";
} else {
    echo "No se pudo eliminar la colección";
}
```

## 3. Obtener colección

```php
$chroma = new ChromaDBClient(
    host: '34.133.165.149',
    port: '32768',
    token: 'test-token-chroma-local-dev'
);

$result = $chromadb->getCollection('mi_coleccion');

if ($result['status']) {
    echo "Colección obtenida: " . json_encode($result['details']);
} else {
    echo "Error: " . $result['message'];
}
```

## 4. Actualizar colección

```php
// Inicializar el cliente
$chroma = new ChromaDBClient(
    host: '34.133.165.149',
    port: '32768',
    token: 'test-token-chroma-local-dev'
);

// Actualizar solo el nombre
if ($chromadb->updateCollection(
    collectionId: 'test-collection-id',
    newName: 'nuevo-nombre-coleccion'
)) {
    echo "Nombre de la colección actualizado exitosamente";
}

// Actualizar solo los metadatos
if ($chromadb->updateCollection(
    collectionId: 'test-collection-id',
    newMetadata: ['description' => 'Nueva descripción']
)) {
    echo "Metadatos de la colección actualizados exitosamente";
}

// Actualizar tanto el nombre como los metadatos
if ($chromadb->updateCollection(
    collectionId: 'test-collection-id',
    newName: 'nuevo-nombre',
    newMetadata: ['description' => 'Nueva descripción']
)) {
    echo "Colección actualizada exitosamente";
}
```

## 5. Listar colecciones

```php
$chroma = new ChromaDBClient(
    host: '34.133.165.149',
    port: '32768',
    token: 'test-token-chroma-local-dev'
);

// Listar todas las colecciones
$result = $chromadb->listCollections();

// Listar con paginación
$result = $chromadb->listCollections(limit: 10, offset: 0);

if ($result['status']) {
    foreach ($result['details']['collections'] as $collection) {
        echo "Collection: " . $collection['name'] . "\n";
    }
} else {
    echo "Error: " . $result['message'];
}
```

## 6. Conteo de colecciones

```php
$chroma = new ChromaDBClient(
    host: '34.133.165.149',
    port: '32768',
    token: 'test-token-chroma-local-dev'
);

$result = $chromadb->countCollections();

if ($result['status']) {
    echo "Número total de colecciones: " . $result['count'];
} else {
    echo "Error: " . $result['message'];
}
```

##7. Contar documentos(items) en una colección

```php
$collection=$chromadb->getCollection($collection_name);
$collection_id=$collection['id'];
// Contar items en una colección
$result = $chromadb->countItems($collection_id);
if ($result['status']) {
    echo "Número de items en la colección: " . $result['count'];
} else {
    echo "Error: " . $result['message'];
}
``` 

## 8. Crear un nuevo documento(item)

```php
// Ejemplo básico: solo IDs y documentos
$result = $chromadb->addItems(
    collectionId: 'test-collection-id',
    ids: ['item1', 'item2'],
    documents: ['texto del documento 1', 'texto del documento 2']
);

// Ejemplo completo: con metadatos y embeddings
$result = $chromadb->addItems(
    collectionId: 'test-collection-id',
    ids: ['item1', 'item2'],
    documents: ['texto del documento 1', 'texto del documento 2'],
    metadatas: [
        ['title' => 'metadata1'],
        ['title' => 'metadata2']
    ],
    embeddings: [
        [0.1, 0.2, 0.3],
        [0.4, 0.5, 0.6]
    ]
);

if ($result['status']) {
    echo "Items agregados exitosamente: " . $result['items_count'] . " items";
} else {
    echo "Error: " . $result['message'];
}
```

## 9. Eliminar un documento

```php
$collection=$chromadb->getCollection($collection_name);
$collection_id=$collection['id'];
// Eliminar por IDs específicos
$result = $chromadb->deleteItems(collectionId: $collection_id,ids: ['item1', 'item2']);
// Eliminar usando condiciones where
$result = $chromadb->deleteItems(collectionId: $collection_id,where: ['metadata_field' => 'value_to_match']);
// Eliminar usando condiciones where_document
$result = $chromadb->deleteItems(collectionId: $collection_id,whereDocument: ['$contains' => 'texto a buscar']);
// Eliminar usando combinación de filtros
$result = $chromadb->deleteItems(collectionId: $collection_id,ids: ['item1'],where: ['metadata_field' => 'value'],whereDocument: ['$contains' => 'texto']);

if ($result['status']) {
    echo "Items eliminados exitosamente: " . $result['items_deleted'] . " items";
} else {
    echo "Error: " . $result['message'];
}
```

## 10. Obtener documentos(items)

```php
$collection=$chromadb->getCollection($collection_name);
$collection_id=$collection['id'];
// Obtener items específicos por ID
$result = $chromadb->getItems(collectionId: $collection_id,ids: ['item1', 'item2'],include: ['documents', 'metadatas']);
// Obtener items con paginación
$result = $chromadb->getItems(collectionId: $collection_id,ids: ['item1', 'item2'],limit: 10,offset: 0);
// Obtener items con filtros
$result = $chromadb->getItems(collectionId: $collection_id,ids: ['item1', 'item2'],where: ['metadata_field' => 'value'],whereDocument: ['$contains' => 'texto']);

if ($result['status']) {
    foreach ($result['items'] as $item) {
        echo "Item ID: " . $item['id'] . "\n";
        if (isset($item['document'])) {
            echo "Document: " . $item['document'] . "\n";
        }
    }
} else {
    echo "Error: " . $result['message'];
}
```

## 11. Consultar documentos(items) por similitud

```php
$collection=$chromadb->getCollection($collection_name);
$collection_id=$collection['id'];
// Búsqueda por embeddings
$result = $chromadb->queryItems(
    collectionId: $collection_id,
    queryEmbeddings: [[0.1, 0.2, 0.3]],
    include: ['documents', 'metadatas', 'distances'],
    nResults: 5
);

// Búsqueda por texto
$result = $chromadb->queryItems(
    collectionId: $collection_id,
    queryTexts: ['texto a buscar'],
    include: ['documents', 'metadatas'],
    nResults: 3
);

// Búsqueda con filtros
$result = $chromadb->queryItems(
    collectionId: $collection_id,
    queryTexts: ['texto a buscar'],
    where: ['metadata_field' => 'value'],
    whereDocument: ['$contains' => 'palabra clave'],
    include: ['documents', 'metadatas', 'distances'],
    nResults: 10
);

if ($result['status']) {
    foreach ($result['results'] as $match) {
        echo "Document: " . $match['document'] . "\n";
        echo "Distance: " . $match['distance'] . "\n";
    }
} else {
    echo "Error: " . $result['message'];
}

//$documents=$similars['results']['documents'];

```

## 12. Actualizar un documentos(items)

```php
$collection=$chromadb->getCollection($collection_name);
$collection_id=$collection['id'];
// Actualizar solo documentos
$result = $chromadb->updateItems(
    collectionId: $collection_id,
    ids: ['item1', 'item2'],
    documents: ['nuevo documento 1', 'nuevo documento 2']
);
// Actualizar documentos y metadatos
$result = $chromadb->updateItems(
    collectionId: $collection_id,
    ids: ['item1', 'item2'],
    documents: ['nuevo documento 1', 'nuevo documento 2'],
    metadatas: [
        ['title' => 'nuevo título 1'],
        ['title' => 'nuevo título 2']
    ]
);
// Actualizar embeddings
$result = $chromadb->updateItems(
    collectionId: $collection_id,
    ids: ['item1', 'item2'],
    embeddings: [
        [0.1, 0.2, 0.3],
        [0.4, 0.5, 0.6]
    ]
);
// Actualizar todo
$result = $chromadb->updateItems(
    collectionId: $collection_id,
    ids: ['item1', 'item2'],
    documents: ['nuevo documento 1', 'nuevo documento 2'],
    metadatas: [
        ['title' => 'nuevo título 1'],
        ['title' => 'nuevo título 2']
    ],
    embeddings: [
        [0.1, 0.2, 0.3],
        [0.4, 0.5, 0.6]
    ]
);

if ($result['status']) {
    echo "Items actualizados exitosamente: " . $result['items_updated'] . " items";
} else {
    echo "Error: " . $result['message'];
}
```

## 13. Guardar(Upsert) de documentos(items)

```php
$collection=$chromadb->getCollection($collection_name);
$collection_id=$collection['id'];
// Upsert básico con documentos
$result = $chromadb->saveItems(
    collectionId: $collection_id,
    ids: ['item1', 'item2'],
    documents: ['documento 1', 'documento 2']
);

// Upsert con documentos y metadatos
$result = $chromadb->saveItems(
    collectionId: $collection_id,
    ids: ['item1', 'item2'],
    documents: ['documento 1', 'documento 2'],
    metadatas: [
        ['title' => 'título 1', 'category' => 'cat1'],
        ['title' => 'título 2', 'category' => 'cat2']
    ]
);

// Upsert completo con embeddings
$result = $chromadb->saveItems(
    collectionId: $collection_id,
    ids: ['item1', 'item2'],
    documents: ['documento 1', 'documento 2'],
    metadatas: [
        ['title' => 'título 1'],
        ['title' => 'título 2']
    ],
    embeddings: [
        [0.1, 0.2, 0.3],
        [0.4, 0.5, 0.6]
    ]
);

if ($result['status']) {
    echo "Items procesados exitosamente: " . $result['items_affected'] . " items";
} else {
    echo "Error: " . $result['message'];
}
```

## 14. Crear Base de Datos

Los "tenants" en ChromaDB (y en general en arquitecturas multi-tenant) son una forma de separar y aislar datos para
diferentes usuarios u organizaciones dentro de la misma instancia de la base de datos.

```php
// Crear una base de datos simple
$result = $chroma->createDatabase(name: 'mi_base_de_datos');
// Crear una base de datos con tenant específico
$result = $chroma->createDatabase(name: 'mi_base_de_datos',tenant: 'mi_tenant');

if ($result['status']) {
    echo "Base de datos creada exitosamente: " . $result['database_name'];
    if ($result['tenant']) {
        echo " (Tenant: " . $result['tenant'] . ")";
    }
} else {
    echo "Error: " . $result['message'];
}
```

## 15. Obtener Base de Datos

```php
$chroma = new ChromaDBClient(
    host: '34.133.165.149',
    port: '32768',
    token: 'test-token-chroma-local-dev'
);

// Obtener información de una base de datos
$result = $chroma->getDatabase('mi_base_de_datos');

// Obtener información de una base de datos con tenant específico
$result = $chroma->getDatabase(
    name: 'mi_base_de_datos',
    tenant: 'mi_tenant'
);

if ($result['status']) {
    echo "Base de datos encontrada: " . $result['database_name'];
    if ($result['tenant']) {
        echo " (Tenant: " . $result['tenant'] . ")";
    }
} else {
    echo "Error: " . $result['message'];
}
```

## 16. Eliminar una base de datos

```php
$chroma = new ChromaDBClient(
    host: '34.133.165.149',
    port: '32768',
    token: 'test-token-chroma-local-dev'
);

// Eliminar una base de datos
$result = $chroma->deleteDatabase('mi_base_de_datos');

// Eliminar una base de datos de un tenant específico
$result = $chroma->deleteDatabase(
    name: 'mi_base_de_datos',
    tenant: 'mi_tenant'
);

// Ejemplo con manejo de errores
try {
    $result = $chroma->deleteDatabase('mi_base_de_datos');
    
    if ($result['status']) {
        echo "Base de datos eliminada exitosamente: " . $result['database_name'];
        if ($result['tenant']) {
            echo " (Tenant: " . $result['tenant'] . ")";
        }
    } else {
        echo "Error al eliminar la base de datos: " . $result['message'];
    }
} catch (Exception $e) {
    echo "Error inesperado: " . $e->getMessage();
}

// Ejemplo de eliminación con verificación previa
$db = $chroma->getDatabase('mi_base_de_datos');
if ($db['status']) {
    $result = $chroma->deleteDatabase('mi_base_de_datos');
    echo $result['status'] ? "Base de datos eliminada" : "Error al eliminar";
} else {
    echo "La base de datos no existe";
}
```

