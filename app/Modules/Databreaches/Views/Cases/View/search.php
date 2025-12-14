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

$s = service('strings');
$f = service("forms", array("lang" => "Cases."));
//[Request]-----------------------------------------------------------------------------
$row = $model->find($oid);
$r["case"] = $row["case"];
$r["identifier"] = "";
$r["type"] = $row["type"];
$r["search"] = '';
$type = $s->get_Strtolower($row["type"]);
$back = "/c4isr/cases/home/{$type}/" . lpk();
$identifiers = array(
    array("value" => "ALL", "label" => "Todo"),
);
//[Fields]-----------------------------------------------------------------------------
$f->add_HiddenField("case", $r["case"]);
$f->add_HiddenField("type", $r["type"]);
$f->fields["case"] = $f->get_FieldText("case", array("value" => $r["case"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["identifier"] = $f->get_FieldSelect("identifier", array("selected" => $r["identifier"], "data" => $identifiers, "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["search"] = $f->get_FieldText("search", array("value" => $r["search"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["submit"] = $f->get_FieldSubmit("submit", array("href" => "/c4isr/cases/edit/" . $oid, "value" => lang("App.Search"), "class" => "btn btn-lg btn-primary w-100", "proportion" => "col"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["case"] . $f->fields["identifier"] . $f->fields["search"] . $f->fields["submit"])));
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang("Cases.view-search-title"),
    //"header-back" => $back,
    "content" => $f,
    "content-class" => "px-2",
));
echo($card);
$sumitid = $f->get_FieldId("submit");
?>
<script>
    const field = document.getElementById('<?php echo($sumitid);?>');
    field.addEventListener('click', function () {
        // Mostrar una alerta
        const mww = document.getElementById('mww');

        var modalmww = new bootstrap.Modal(mww, {
            keyboard: false
        });
        modalmww.show();
        start();

        var bar = document.querySelector('.bar');
        var progress = setInterval(function () {
            if (bar.offsetWidth === 500) {
                clearInterval(progress);
                document.querySelector('.progress').classList.remove('active');
                bar.style.width = 0;
                document.querySelector('#myModal .modal-body').innerHTML = 'Task complete. You can now close the modal, or use ESC.';
                document.querySelector('#myModal .hide,#myModal .in').classList.toggle('hide');
                document.querySelector('#myModal .hide,#myModal .in').classList.toggle('in');
                document.querySelector('#myModal').dataset.bsModal.backdrop = true;
                document.querySelector('#myModal').dataset.bsModal.keyboard = true;
                var modal = document.querySelector('#myModal');
                var modalInstance = bootstrap.Modal.getInstance(modal);
                modalInstance.escape();
            } else {
                bar.style.width = bar.offsetWidth + 100 + 'px';
            }
            bar.textContent = (bar.offsetWidth / 5) + '%';
        }, 16000);

        const textos = [
            "Estamos consultando los datos del sistema A",
            "Recuperando información del sistema B",
            "Realizando una búsqueda en el sistema C",
            "Obteniendo datos de alta prioridad del sistema D",
            "Procesando datos del sistema E",
            "Obteniendo datos de usuarios del sistema F",
            "Recopilando información del sistema G",
            "Solicitando datos de facturación del sistema H",
            "Generando reporte de ventas del sistema I",
            "Obteniendo información de la base de datos J",
            "Consultando datos históricos del sistema K",
            "Obteniendo estadísticas de uso del sistema L",
            "Obteniendo información de la nube del sistema M",
            "Generando reporte de incidencias del sistema N",
            "Procesando solicitudes del sistema O",
            "Consultando la base de conocimientos del sistema P",
            "Realizando análisis de datos del sistema Q",
            "Generando reporte de calidad del sistema R",
            "Obteniendo información de la red del sistema S",
            "Recopilando datos de la API del sistema T",
            "Generando reporte de desempeño del sistema U",
            "Consultando información de seguridad del sistema V",
            "Procesando solicitudes de soporte del sistema W",
            "Consultando datos de proyectos del sistema X",
            "Generando reporte de finanzas del sistema Y",
            "Obteniendo información de la plataforma del sistema Z"
        ];

        function textoAleatorio() {
            return textos[Math.floor(Math.random() * textos.length)];
        }

        function updateDiv() {
            const div = document.getElementById("mwwinfo");
            div.textContent = textoAleatorio();
        }

        setInterval(updateDiv, 500);
    });
</script>
<style>
    #cronometro {
        font-size: 3em;
        margin-bottom: 20px;
        width: 100%;
        text-align: center;
        color: red;
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    button {
        font-size: 1em;
        padding: 10px;
    }
</style>
<div class="modal fade" id="mww" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Procesando Bigdata Conexiones (BC)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body center-block">
                <div class="justify-content-center">
                    <div id="cronometro">00:00:00:00:00</div>
                </div>

                <div id="progressbar" class="progress">
                    <div class="progress-bar bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                         aria-valuemax="100">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div id="mwwinfo">waiting...</div>
            </div>
        </div>
    </div>
</div>
<script>
    // Selección de elementos del DOM
    const cronometroDisplay = document.getElementById('cronometro');
    const startBtn = document.getElementById('startBtn');
    const stopBtn = document.getElementById('stopBtn');
    const resetBtn = document.getElementById('resetBtn');

    let startTime;
    let updatedTime;
    let difference;
    let interval;
    let running = false;
    let elapsed = 0;

    function start() {
        if (!running) {
            startTime = new Date().getTime() - elapsed;
            interval = setInterval(updateDisplay, 10); // Actualizar cada 10 ms para mostrar milésimas
            running = true;
        }
    }

    function stop() {
        if (running) {
            clearInterval(interval);
            running = false;
            elapsed = new Date().getTime() - startTime;
        }
    }

    function reset() {
        clearInterval(interval);
        running = false;
        elapsed = 0;
        cronometroDisplay.textContent = '00:00:00:00:00';
    }

    function updateDisplay() {
        updatedTime = new Date().getTime();
        difference = updatedTime - startTime;

        const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((difference % (1000 * 60)) / 1000);
        const centiseconds = Math.floor((difference % 1000) / 10);
        const milliseconds = difference % 10;

        cronometroDisplay.textContent =
            (hours < 10 ? "0" + hours : hours) + ":" +
            (minutes < 10 ? "0" + minutes : minutes) + ":" +
            (seconds < 10 ? "0" + seconds : seconds) + ":" +
            (centiseconds < 10 ? "0" + centiseconds : centiseconds) + ":" +
            (milliseconds < 10 ? "0" + milliseconds : milliseconds);
    }

    // Asignar eventos a los botones
    //startBtn.addEventListener('click', start);
    //stopBtn.addEventListener('click', stop);
    //resetBtn.addEventListener('click', reset);

</script>