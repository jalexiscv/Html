<?php

$mmodules = model("App\\Models\\Application_Modules");
$mclientmodules = model("App\\Models\\Application_Clients_Modules");
$client = safe_get_client();

$modules = $mclientmodules->getCachedAuthorizedModulesByClient($client);

$code = "<!-- Modal de Módulos -->\n";
$code .= "<div class=\"modal fade\" id=\"higgs-options-modules\" tabindex=\"-1\" aria-labelledby=\"higgs-options-modules-label\" aria-hidden=\"true\">\n";
$code .= "\t\t<div class=\"modal-dialog modal-xl modal-dialog-centered\">\n";
$code .= "\t\t\t\t<div class=\"modal-content\">\n";
$code .= "\t\t\t\t\t\t<div class=\"modal-header\">\n";
$code .= "\t\t\t\t\t\t\t\t<h5 class=\"modal-title\" id=\"modulesModalLabel\">\n";
$code .= "\t\t\t\t\t\t\t\t\t\t<i class=\"fas fa-cubes me-2\"></i> Módulos Disponibles\n";
$code .= "\t\t\t\t\t\t\t\t</h5>\n";
$code .= "\t\t\t\t\t\t\t\t<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>\n";
$code .= "\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t\t\t<div class=\"modal-body\">\n";
$code .= "\t\t\t\t\t\t\t\t<div class=\"container-fluid p-0\">\n";

$code .= "<div class=\"input-group mb-4\">\n";
$code .= "\t <span class=\"input-group-text bg-secondary text-white\">\n";
$code .= "\t\t <i class=\"fas fa-search\"></i>\n";
$code .= "\t </span>\n";
$code .= "\t <input type=\"text\" id=\"moduleSearch\" class=\"form-control\" placeholder=\"Buscar módulos...\">\n";
$code .= "</div>\n";


$code .= "\t\t\t\t\t\t\t\t\t\t<div class=\"row g-6\">\n";
foreach ($modules as $module) {
    if (!empty($module["module"])) {
        if (safe_has_permission("{$module['alias']}-ACCESS")) {
            $title = lang("Modules." . $module["title"]);
            $alias = safe_strtolower($module["alias"]);

            $iconPath = "/themes/assets/icons/png/" . strtolower(@$module['alias']) . "-128x128.png";
            $icon = file_exists($_SERVER['DOCUMENT_ROOT'] . $iconPath) ? $iconPath : "/themes/assets/icons/application.svg";

            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t<!-- Módulo 1 -->\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"col-sm-2 mb-3 module-item\">\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"card module-card shadow-sm\">\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"card-body p-2\">\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<img src=\"{$icon}?v4\" class=\"img-responsive opacity-10\" style=\"width:128px;height:128px;\">\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t <a href=\"/{$alias}\" class=\"mt-1 stretched-link text-decoration-none\">";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<h5 class=\"card-title\">{$title}</h5>\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t </a>\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t</div>\n";
        }
    }
}

//Mensaje cuando no hay resultados
$code .= "\t\t\t\t\t\t\t\t\t\t\t\t<div id=\"noResults\" class=\"text-center p-4 hidden\">\n";
$code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"fas fa-search fa-3x text-muted mb-3\"></i>\n";
$code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t<h4 class=\"text-muted\">No se encontraron módulos</h4>\n";
$code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t<p class=\"text-muted\">Intenta con otra palabra clave</p>\n";
$code .= "\t\t\t\t\t\t\t\t\t\t\t\t</div>\n";

$code .= "\t\t\t\t\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t\t\t<div class=\"modal-footer justify-content-between\">\n";
$code .= "\t\t\t\t\t\t\t\t<div>\n";
$code .= "\t\t\t\t\t\t\t\t\t\t<button type=\"button\" class=\"btn btn-outline-secondary\" data-bs-dismiss=\"modal\">Cerrar</button>\n";
$code .= "\t\t\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t\t\t\t\t<div>\n";
$code .= "\t\t\t\t\t\t\t\t\t\t<button id=\"btn-modal-modules-refresh\" type=\"button\" class=\"btn btn-primary\" >\n";
$code .= "\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"fas fa-sync-alt me-1\"></i> Actualizar\n";
$code .= "\t\t\t\t\t\t\t\t\t\t</button>\n";
$code .= "\t\t\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t\t\t</div>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t</div>\n";
$code .= "</div>\n";
echo($code);
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Elementos del DOM
        const searchInput = document.getElementById('moduleSearch');
        const moduleItems = document.querySelectorAll('.module-item');
        const noResultsElement = document.getElementById('noResults');

        // Función para filtrar módulos
        function filterModules() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            let foundResults = false;

            // Recorrer todos los módulos
            moduleItems.forEach(item => {
                const moduleTitle = item.querySelector('.card-title').textContent.toLowerCase();

                // Verificar si el título del módulo contiene el término de búsqueda
                if (moduleTitle.includes(searchTerm) || searchTerm === '') {
                    item.classList.remove('hidden');
                    item.querySelector('.module-card').classList.add('search-result');
                    foundResults = true;

                    // Eliminar la clase de animación después de la animación
                    setTimeout(() => {
                        item.querySelector('.module-card').classList.remove('search-result');
                    }, 500);
                } else {
                    item.classList.add('hidden');
                }
            });

            // Mostrar o ocultar el mensaje de "No se encontraron resultados"
            if (foundResults || searchTerm === '') {
                noResultsElement.classList.add('hidden');
            } else {
                noResultsElement.classList.remove('hidden');
            }
        }

        // Evento para detectar cambios en el campo de búsqueda
        searchInput.addEventListener('input', filterModules);

        // Limpiar la búsqueda al abrir el modal
        document.getElementById('higgs-options-modules').addEventListener('show.bs.modal', function () {
            searchInput.value = '';
            filterModules();
        });


        document.getElementById('btn-modal-modules-refresh').addEventListener('click', function () {
            fetch('/frontend/api/refresh/json/cache/clear', {
                method: 'POST'
            })
                .then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        console.error('Error en la solicitud:', response.status);
                    }
                })
                .catch(error => {
                    console.error('Error en la conexión:', error);
                });
        });


    });
</script>


<style>
    #higgs-options-modules .module-card {
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
        border-radius: 10px;
        overflow: hidden;
        height: 100%;
    }

    #higgs-options-modules .module-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    #higgs-options-modules .module-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
    }


    #higgs-options-modules .btn-close {
        filter: brightness(0) invert(1);
    }

    #higgs-options-modules .card-body {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 1.5rem;
    }

    #higgs-options-modules .card-title {
        font-size: 12px;
        color: #7e7e7e;
    }

    #higgs-options-modules .badge-module {
        position: absolute;
        top: 10px;
        right: 10px;
    }

    #higgs-options-modules .hidden {
        display: none !important;
    }

    /* Animación para los resultados de búsqueda */
    #higgs-options-modules

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    #higgs-options-modules .module-card.search-result {
        animation: fadeIn 0.3s ease-in-out;
    }
</style>