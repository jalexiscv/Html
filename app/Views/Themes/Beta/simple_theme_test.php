<?php
/**
 * Test simple del sistema de temas sin dependencias externas
 */

// Iniciar sesión
session_start();

// Simular ThemeManager básico
class SimpleThemeManager
{
    public static function getBodyClass()
    {
        $theme = self::getCurrentTheme();
        switch ($theme) {
            case 'dark':
                return 'dark-mode';
            case 'light':
                return 'light-mode';
            default:
                // Para auto, detectar por hora del día
                $hour = (int)date('H');
                return ($hour >= 20 || $hour <= 6) ? 'dark-mode' : 'light-mode';
        }
    }

    public static function getCurrentTheme()
    {
        if (isset($_GET['theme']) && in_array($_GET['theme'], ['light', 'dark', 'auto'])) {
            $_SESSION['theme'] = $_GET['theme'];
            return $_GET['theme'];
        }

        return $_SESSION['theme'] ?? 'auto';
    }
}

$currentTheme = SimpleThemeManager::getCurrentTheme();
$bodyClass = SimpleThemeManager::getBodyClass();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Simple de Temas PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        /* Estilos básicos para modo oscuro */
        .dark-mode {
            background-color: #18191A !important;
            color: #E4E6EA !important;
        }

        .dark-mode .card {
            background-color: #242526 !important;
            color: #E4E6EA !important;
            border-color: #3A3B3C !important;
        }

        .dark-mode .card-header {
            background-color: #2D2E2F !important;
            color: #E4E6EA !important;
            border-color: #3A3B3C !important;
        }

        .dark-mode .btn-outline-primary {
            color: #2D88FF !important;
            border-color: #2D88FF !important;
        }

        .dark-mode .btn-outline-primary:hover {
            background-color: #2D88FF !important;
            color: #FFFFFF !important;
        }

        .dark-mode .alert-info {
            background-color: #1e3a5f !important;
            border-color: #2D88FF !important;
            color: #E4E6EA !important;
        }

        /* Estilos para modo claro */
        .light-mode {
            background-color: #FFFFFF !important;
            color: #1C1E21 !important;
        }

        .light-mode .card {
            background-color: #FFFFFF !important;
            color: #1C1E21 !important;
            border-color: #DADDE1 !important;
        }

        /* Modo automático - usa CSS nativo */
        .theme-auto {
            background-color: #FFFFFF;
            color: #1C1E21;
        }

        @media (prefers-color-scheme: dark) {
            .theme-auto {
                background-color: #18191A !important;
                color: #E4E6EA !important;
            }

            .theme-auto .card {
                background-color: #242526 !important;
                color: #E4E6EA !important;
                border-color: #3A3B3C !important;
            }

            .theme-auto .card-header {
                background-color: #2D2E2F !important;
                color: #E4E6EA !important;
                border-color: #3A3B3C !important;
            }
        }
    </style>
</head>

<body class="<?php echo $bodyClass; ?>">
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>✅ Test Simple - Sistema de Temas PHP</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <strong>🎉 ¡FUNCIONANDO!</strong><br>
                        El &lt;body&gt; se generó desde PHP con la clase correcta.
                    </div>

                    <div class="alert alert-info">
                        <strong>Información del Tema:</strong><br>
                        <strong>Tema actual:</strong> <?php echo $currentTheme; ?><br>
                        <strong>Clase del body:</strong> <code><?php echo $bodyClass; ?></code><br>
                        <strong>Generado desde:</strong> PHP (servidor)<br>
                        <strong>Sin JavaScript:</strong> ✅ Sin parpadeo
                    </div>

                    <div class="btn-group" role="group">
                        <a href="?theme=light"
                           class="btn btn-outline-primary <?php echo $currentTheme === 'light' ? 'active' : ''; ?>">
                            <i class="fas fa-sun"></i> Modo Claro
                        </a>
                        <a href="?theme=dark"
                           class="btn btn-outline-primary <?php echo $currentTheme === 'dark' ? 'active' : ''; ?>">
                            <i class="fas fa-moon"></i> Modo Oscuro
                        </a>
                        <a href="?theme=auto"
                           class="btn btn-outline-primary <?php echo $currentTheme === 'auto' ? 'active' : ''; ?>">
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
                                    <p class="card-text">Este card cambia de colores según el tema aplicado desde
                                        PHP.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Información Técnica</strong>
                                </div>
                                <div class="card-body">
                                    <p><strong>Método:</strong> PHP Server-Side</p>
                                    <p>
                                        <strong>Sesión:</strong> <?php echo isset($_SESSION['theme']) ? $_SESSION['theme'] : 'No definida'; ?>
                                    </p>
                                    <p><strong>GET:</strong> <?php echo $_GET['theme'] ?? 'No definido'; ?></p>
                                    <p><strong>Parpadeo:</strong> ❌ Eliminado</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
