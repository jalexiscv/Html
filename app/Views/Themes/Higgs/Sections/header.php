<?php
/** @var string $theme */
/** @var string $main_template */
/** @var string $breadcrumb */
/** @var string $main */
/** @var string $right */
/** @var string $left */
/** @var string $logo_portrait */
/** @var string $logo_landscape */
/** @var string $logo_portrait_light */
/** @var string $logo_landscape_light */
/** @var string $canonical */
/** @var string $type */
/** @var string $title */
/** @var string $description */
/** @var string $messenger */
/** @var string $messenger_users */
/** @var string $benchmark */
/** @var string $version */
$data = array(
    "theme" => $theme,
    "main_template" => $main_template,
    "breadcrumb" => $breadcrumb,
    "main" => $main,
    "right" => $right,
    "left" => $left,
    "logo_portrait" => $logo_portrait,
    "logo_landscape" => $logo_landscape,
    "logo_portrait_light" => $logo_portrait_light,
    "logo_landscape_light" => $logo_landscape_light,
    "canonical" => $canonical,
    "type" => $type,
    "title" => $title,
    "description" => $description,
    "messenger" => $messenger,
    "messenger_users" => $messenger_users,
    "benchmark" => $benchmark,
    "version" => $version,
);
?>
<nav class="navbar navbar-expand-lg border-bottom p-3 sidebar-header">
    <div class="container-fluid m-0  p-0">
        <?php echo(view($theme . '\Includes\header-main-left', $data)); ?>
        <?php echo(view($theme . '\Includes\header-main-right', $data)); ?>
    </div>
</nav>
<script>
    window.addEventListener('load', () => {
        try {
            const light = document.getElementById('ilight');
            const dark = document.getElementById('idark');
            if (!light || !dark) {
                console.warn("No se encontraron los elementos 'ilight' o 'idark' en el DOM.");
                return;
            }

            if (body.classList.contains('theme-dark')) {
                light.classList.remove('d-none');
                dark.classList.add('d-none');
            } else {
                light.classList.add('d-none');
                dark.classList.remove('d-none');
            }

            light.addEventListener('click', () => {
                light.classList.add('d-none');
                dark.classList.remove('d-none');
            });

            dark.addEventListener('click', () => {
                light.classList.remove('d-none');
                dark.classList.add('d-none');
            });
        } catch (error) {
            console.error("Error al inicializar el control de tema:", error);
        }

    });
</script>