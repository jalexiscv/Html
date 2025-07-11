<?php
/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */

include "headers.php";

$onLoadExtras = "";
$pluginsDisplay = "";

// Show plugins
if ($_SESSION['loggedIn']) {
    // Work out the plugins to display to the user
    $pluginsDisplay = "";
    for ($i = 0; $i < count($ICEcoder["plugins"]); $i++) {
        $target = explode(":", $ICEcoder["plugins"][$i][4]);
        $pluginsDisplay .=
            '<a href="' . $ICEcoder["plugins"][$i][3] .
            '" title="' . $ICEcoder["plugins"][$i][0] .
            '" target="' . $target[0] .
            '"><img src="' . $ICEcoder["plugins"][$i][1] .
            '" style="' . $ICEcoder["plugins"][$i][2] .
            '" alt="' . $ICEcoder["plugins"][$i][0] .
            '"></a><br><br>';
    };

    // If we're updating plugins, update those shown
    if (isset($_GET['updatedPlugins'])) {
        echo "<script>parent.document.getElementById('pluginsOptional').innerHTML = '" . str_replace("'", "\\'", $pluginsDisplay) . "';</script>";
    }

    // Work out what plugins we'll need to set on a setInterval
    $onLoadExtras = "";
    for ($i = 0; $i < count($ICEcoder["plugins"]); $i++) {
        if ($ICEcoder["plugins"][$i][5] != "") {
            $onLoadExtras .=
                ";ICEcoder.startPluginIntervals(" . $i . ",'" .
                $ICEcoder["plugins"][$i][3] . "','" .
                $ICEcoder["plugins"][$i][4] . "','" .
                $ICEcoder["plugins"][$i][5] .
                "')";
        };
    };

    // If we're updating our plugins, clear existing setIntervals & the array refs, then start new ones
    if (isset($_GET['updatedPlugins'])) {
        ?>
        <script>
            for (let i = 0; i <= parent.ICEcoder.pluginIntervalRefs.length - 1; i++) {
                clearInterval(parent.ICEcoder['plugTimer' + parent.ICEcoder.pluginIntervalRefs[i]]);
            }
            parent.ICEcoder.pluginIntervalRefs = [];
            <?php echo $onLoadExtras . PHP_EOL; ?>
        </script>
        <?php
    }
}
?>
