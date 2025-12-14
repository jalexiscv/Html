<?php
/** @var string $table */
$migrations = \Config\Services::migrations();
try {
    $migrations->setNamespace('App\Modules\Frontend');// Set the namespace for the current module
    $migrations->latest();// Run the migrations for the current module
    $all = $migrations->findMigrations();// Find all migrations for the current module
    foreach ($all as $migration) {
        echo "<br>Migraciones ejecutadas exitosamente {$migration->path} para el módulo {$migration->namespace}.";
    }
    $file_name = __FILE__;
    echo "<br>Migraciones ejecutadas exitosamente {$file_name} para todos los módulos.";
} catch (\Throwable $e) {
    echo "Error ejecutando las migraciones: " . $e->getMessage();// Manejar cualquier error que ocurra
}


?>