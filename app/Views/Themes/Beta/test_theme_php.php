<?php
/**
 * Test del sistema de temas basado en PHP
 * Este archivo prueba que el <body> se genere con la clase correcta desde el servidor
 */

// Incluir el sistema de temas
require_once 'php/autoload.php';

// Obtener información del tema actual para mostrar en la página
$currentTheme = get_current_theme();
$bodyClass = get_theme_body_class();
$isDark = is_dark_theme();

// Simular datos de prueba
$data = [
    'title' => 'Test de Temas PHP',
    'content' => '
        <div class="container mt-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Prueba del Sistema de Temas PHP</h4>
                        </div>
                        <div class="card-body">
                            <p>Esta página prueba el sistema de temas basado en PHP que elimina el parpadeo.</p>
                            
                            <div class="alert alert-info">
                                <strong>Tema actual:</strong> <span id="current-theme">' . $currentTheme . '</span><br>
                                <strong>Clase del body:</strong> <code>' . $bodyClass . '</code><br>
                                <strong>Es modo oscuro:</strong> ' . ($isDark ? 'Sí' : 'No') . '
                            </div>
                            
                            <div class="btn-group" role="group">
                                <a href="?theme=light" class="btn btn-outline-primary">
                                    <i class="fas fa-sun"></i> Modo Claro
                                </a>
                                <a href="?theme=dark" class="btn btn-outline-primary">
                                    <i class="fas fa-moon"></i> Modo Oscuro
                                </a>
                                <a href="?theme=auto" class="btn btn-outline-primary">
                                    <i class="fas fa-adjust"></i> Automático
                                </a>
                            </div>
                            
                            <hr>
                            
                            <h5>Prueba de Componentes</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">Card de Prueba</h6>
                                            <p class="card-text">Este card debe cambiar de colores según el tema.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Columna 1</th>
                                                <th>Columna 2</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Dato 1</td>
                                                <td>Dato 2</td>
                                            </tr>
                                            <tr>
                                                <td>Dato 3</td>
                                                <td>Dato 4</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    '
];

// Renderizar usando BetaRenderer
$renderer = new BetaRenderer();
echo $renderer->render('layouts/base.html', $data);
?>
