<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-01-20 20:43:28
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Crm\Views\Tickets\Creator\form.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/

//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Tickets."));
//[models]--------------------------------------------------------------------------------------------------------------
$mtickets = model("App\Modules\Crm\Models\Crm_Tickets");
$magents = model("App\Modules\Crm\Models\Crm_Agents");
//[vars]----------------------------------------------------------------------------------------------------------------
$magents = $magents->findAll();
?>

<style>
    html, body {
        height: 100%;
        margin: 0;
    }

    .full-height {
        min-height: 100vh;
    }

    .turno {
        display: flex; /* Habilita Flexbox */
        flex-direction: column; /* Orientación vertical */
        justify-content: center; /* Centrado vertical */
        align-items: center; /* Centrado horizontal */
        background-color: #ffffff;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        height: 100%;
    }

    .turno-header {
        background-color: #007bff;
        color: #fff;
        padding: 10px 15px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        width: 100%; /* Asegura que el header ocupe toda la anchura de la columna */
    }

    .turno-body {
        /* Ajustes para flexbox con dirección de columna */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100%;
        width: 100%;
    }

    .turno-body .label {
        font-size: 3rem;
        line-height: 3rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .turno-body .value {
        font-size: 5rem;
        line-height: 5rem;
        color: #555;
        margin-bottom: 1rem;
    }

    .turno-body .turno-value {
        color: red;
        font-size: 10rem;
        line-height: 10rem;
        margin-bottom: 1rem;
    }
</style>

<div class="container-fluid h-100 p-0 m-0">
    <div class="row full-height p-4">
        <?php foreach ($magents as $agent) { ?>
            <?php $ticket = $mtickets->where("agent", $agent["agent"])->orderBy('number', 'DESC')->first(); ?>
            <div class="col-md-3 mb-3">
                <div class="turno">
                    <div class="turno-header">
                        <?php echo($agent["name"]); ?>
                    </div>
                    <div class="turno-body d-flex flex-column justify-content-center align-items-center">
                        <div class="label">Turno</div>
                        <div class="turno-value"><?php echo(@$ticket["number"]); ?></div>
                        <div class="label">Encargado</div>
                        <div class="value"><?php echo($agent["name"]); ?></div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script>
    // Establece un temporizador para recargar la página cada 3 segundos
    setInterval(function () {
        // Recarga la página
        location.reload(true);
    }, 3000);
</script>



