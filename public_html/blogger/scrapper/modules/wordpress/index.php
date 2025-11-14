<?php
/**
 * Demo de publicación en WordPress
 *
 * - Muestra un formulario HTML prellenado para probar la creación de un post
 *   con título, contenido HTML, categorías, tags, imagen destacada y estado.
 * - Al enviar el formulario (POST), publica usando la librería propia
 *   `WpPublisher` que llama a la REST API de WordPress con Application Passwords.
 * - Las credenciales del sitio WordPress se leen desde el .env mediante EnvLoader.
 * - Sin librerías de terceros.
 */

// Cargar .env y dependencias locales
require_once dirname(__DIR__) . '/inc/EnvLoader.php';
EnvLoader::load();
require_once __DIR__ . '/WpPublisher.php';

// Configuración desde .env
$WP_BASE_URL = "https://buga.com.co";
$WP_USER = "u588086740_jntSs";
$WP_APP_PASS = "gZhTKu91Rg";
$WP_VERIFY_SSL = (bool)env('WP_VERIFY_SSL', true);

// Función utilitaria: escapar HTML de forma segura
function h($s)
{
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

// Valores por defecto del formulario (prellenado)
$def = [
        'title' => 'Título de prueba desde Modules/WordPress',
        'content_html' => "<p>Este es un <strong>contenido HTML</strong> de ejemplo publicado desde el módulo personalizado.</p>\n<p>Incluye etiquetas, negritas, enlaces y el formato que necesites.</p>",
        'categories' => 'Noticias, Tecnología', // separadas por coma
        'tags' => 'Demo, Prueba, API',         // separadas por coma
        'featured_image_url' => 'https://picsum.photos/1200/630.jpg',
        'status' => 'publish', // draft|publish|pending|private
];

$result = null; // aquí guardaremos la respuesta para mostrar feedback

// Si recibimos POST, intentamos publicar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = isset($_POST['title']) ? trim((string)$_POST['title']) : '';
    $content = isset($_POST['content_html']) ? (string)$_POST['content_html'] : '';
    $catsStr = isset($_POST['categories']) ? (string)$_POST['categories'] : '';
    $tagsStr = isset($_POST['tags']) ? (string)$_POST['tags'] : '';
    $featUrl = isset($_POST['featured_image_url']) ? trim((string)$_POST['featured_image_url']) : '';
    $status = isset($_POST['status']) ? (string)$_POST['status'] : 'publish';

    $cats = array_values(array_filter(array_map('trim', explode(',', $catsStr)), function ($v) {
        return $v !== '';
    }));
    $tags = array_values(array_filter(array_map('trim', explode(',', $tagsStr)), function ($v) {
        return $v !== '';
    }));
    $featUrl = $featUrl !== '' ? $featUrl : null;

    // Validaciones mínimas
    $errors = [];
    if ($title === '') $errors[] = 'El título es obligatorio.';
    if ($content === '') $errors[] = 'El contenido HTML es obligatorio.';
    if (!$WP_BASE_URL || !$WP_USER || !$WP_APP_PASS) $errors[] = 'Configura WP_BASE_URL, WP_USER y WP_APP_PASSWORD en el .env';

    if (empty($errors)) {
        try {
            $pub = new WpPublisher($WP_BASE_URL, $WP_USER, $WP_APP_PASS, $WP_VERIFY_SSL);
            $resp = $pub->publishPost($title, $content, $cats, $tags, $featUrl, $status);
            $result = ['ok' => ($resp['status'] >= 200 && $resp['status'] < 300 && empty($resp['error'])), 'resp' => $resp, 'errors' => []];
        } catch (Exception $e) {
            $result = ['ok' => false, 'resp' => null, 'errors' => ['Excepción: ' . $e->getMessage()]];
        }
    } else {
        $result = ['ok' => false, 'resp' => null, 'errors' => $errors];
    }
}

// Render HTML sencillo
?><!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Demo Publicación WordPress</title>
    <style>
        body {
            background: #0d0f12;
            color: #d7dadf;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, Arial, sans-serif;
            margin: 0;
            padding: 24px;
        }

        .container {
            max-width: 920px;
            margin: 0 auto;
        }

        h1 {
            font-size: 22px;
            margin: 0 0 12px;
        }

        .card {
            background: #12151a;
            border: 1px solid #1e232b;
            border-radius: 8px;
            padding: 16px;
            margin: 16px 0;
        }

        label {
            display: block;
            margin: 10px 0 6px;
            font-weight: 600;
        }

        input[type=text], input[type=url], select, textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #2a313c;
            background: #0e1116;
            color: #d7dadf;
        }

        textarea {
            min-height: 160px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, "Liberation Mono", monospace;
        }

        .row {
            display: flex;
            gap: 12px;
        }

        .row > div {
            flex: 1;
        }

        button {
            background: #2563eb;
            border: none;
            color: #fff;
            padding: 10px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }

        .muted {
            color: #94a3b8;
            font-size: 12px;
        }

        .ok {
            color: #10b981;
        }

        .err {
            color: #ef4444;
        }

        pre {
            background: #0b0e13;
            border: 1px solid #1e232b;
            border-radius: 6px;
            padding: 12px;
            overflow: auto;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Demo: Publicación en WordPress</h1>
    <p class="muted">Las credenciales del sitio se leen de .env: <code>WP_BASE_URL</code>, <code>WP_USER</code>, <code>WP_APP_PASSWORD</code>,
        <code>WP_VERIFY_SSL</code>.</p>

    <?php if ($result !== null): ?>
        <div class="card">
            <?php if ($result['ok']): ?>
                <p class="ok"><strong>✔ Publicado correctamente</strong></p>
            <?php else: ?>
                <p class="err"><strong>✖ Error al publicar</strong></p>
                <?php if (!empty($result['errors'])): ?>
                    <ul>
                        <?php foreach ($result['errors'] as $e): ?>
                            <li class="err"><?php echo h($e); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (isset($result['resp']) && is_array($result['resp'])): ?>
                <details open class="card">
                    <summary>Respuesta de la API
                        (status: <?php echo isset($result['resp']['status']) ? (int)$result['resp']['status'] : 0; ?>)
                    </summary>
                    <pre><?php echo h(json_encode($result['resp']['json'] ?? $result['resp'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)); ?></pre>
                </details>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <form method="post" class="card">
        <label for="title">Título</label>
        <input type="text" id="title" name="title" value="<?php echo h($_POST['title'] ?? $def['title']); ?>" required>

        <label for="content_html">Contenido HTML</label>
        <textarea id="content_html" name="content_html"
                  required><?php echo h($_POST['content_html'] ?? $def['content_html']); ?></textarea>

        <div class="row">
            <div>
                <label for="categories">Categorías (separadas por coma)</label>
                <input type="text" id="categories" name="categories"
                       value="<?php echo h($_POST['categories'] ?? $def['categories']); ?>">
            </div>
            <div>
                <label for="tags">Tags (separadas por coma)</label>
                <input type="text" id="tags" name="tags" value="<?php echo h($_POST['tags'] ?? $def['tags']); ?>">
            </div>
        </div>

        <label for="featured_image_url">URL de imagen destacada</label>
        <input type="url" id="featured_image_url" name="featured_image_url"
               value="<?php echo h($_POST['featured_image_url'] ?? $def['featured_image_url']); ?>">

        <div class="row">
            <div>
                <label for="status">Estado</label>
                <select id="status" name="status">
                    <?php
                    $statuses = ['draft' => 'Borrador', 'publish' => 'Publicar', 'pending' => 'Pendiente', 'private' => 'Privado'];
                    $sel = $_POST['status'] ?? $def['status'];
                    foreach ($statuses as $val => $label) {
                        $selected = ($sel === $val) ? ' selected' : '';
                        echo '<option value="' . h($val) . '"' . $selected . '>' . h($label) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div>
                <label>Destino</label>
                <div class="muted">Base URL: <code><?php echo h($WP_BASE_URL); ?></code></div>
                <div class="muted">Usuario: <code><?php echo h($WP_USER); ?></code></div>
                <div class="muted">SSL: <code><?php echo $WP_VERIFY_SSL ? 'verificado' : 'no verificado'; ?></code>
                </div>
            </div>
        </div>

        <div style="margin-top:12px">
            <button type="submit">Publicar en WordPress</button>
        </div>
    </form>

    <p class="muted">Consejo: ajusta los valores por defecto en el formulario para acelerar tus pruebas.</p>
</div>
</body>
</html>