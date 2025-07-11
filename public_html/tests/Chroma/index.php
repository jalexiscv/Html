<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', 60);  // Added this line
error_reporting(E_ALL);

require_once 'Libraries/ChromaDB/ChromaDB.php';

use App\Libraries\ChromaDB\ChromaDB;

$chroma = new ChromaDB();
$selectedCollection = $_GET['collection'] ?? null;
$option = $_GET['option'] ?? null;

// Obtener lista de colecciones
$collections = $chroma->listCollections();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChromaDB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="/themes/assets/fonts/fontawesome/6/css/all.min.css?v=1.1" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container-fluid vh-100 d-flex p-0 ">
    <div class="row w-100">
        <!-- Menú lateral -->
        <div class="col-md-3 col-lg-2 d-md-block bg-dark sidebar px-3">
            <div class="position-sticky px-3 pt-3">
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Colecciones</span>
                </h6>
                <?php include 'menu.php'; ?>
            </div>
        </div>

        <!-- Contenido principal -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">ChromaDB Admin</h1>
            </div>
            <?php
            if ($selectedCollection) {
                if (!empty($option)) {
                    if ($option == "add") {
                        include 'add.php';
                    } elseif ($option == "search") {
                        include 'search.php';
                    } elseif ($option == "delete-collection") {
                        include 'delete-collection.php';
                    } elseif ($option == "delete-item") {
                        include 'delete-item.php';
                    }
                } else {
                    include 'collection.php';
                    include 'items.php';
                }
            } else {
                if ($option) {
                    if ($option == "create-collection") {
                        include 'create-collection.php';
                    }
                } else {
                    echo '<div class="alert alert-info">Seleccione una colección del menú para ver sus items.</div>';
                }
            }
            ?>
        </main>
    </div>
</div>

<!-- Bootstrap JS y Popper.js para los componentes interactivos -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
