<?php
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
    array("value" => "ALIAS", "label" => "Alias"),
    array("value" => "EMAIL", "label" => "Correo Electrónico"),
    array("value" => "DOMAIN", "label" => "Dominio"),
);
//[Fields]-----------------------------------------------------------------------------
$f->add_HiddenField("case", $r["case"]);
$f->add_HiddenField("type", $r["type"]);
$f->fields["case"] = $f->get_FieldView("case", array("value" => $r["case"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["identifier"] = $f->get_FieldSelect("identifier", array("selected" => $r["identifier"], "data" => $identifiers, "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["search"] = $f->get_FieldText("search", array("value" => $r["search"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["submit"] = $f->get_FieldSubmit("submit", array("href" => "/c4isr/cases/edit/" . $oid, "value" => lang("App.Search"), "class" => "btn btn-secondary", "proportion" => "col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["case"] . $f->fields["identifier"] . $f->fields["search"] . $f->fields["submit"])));
//[Build]-----------------------------------------------------------------------------
if ($type == "osint") {
    $ttype = "Osint";
} else {
    $ttype = $type;
}

$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->caching = 0;
$smarty->assign("type", "normal");
$smarty->assign("header", "{$ttype}/{$oid}");
$smarty->assign("header_back", $back);
$smarty->assign("body", $f);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));
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
                    <img src="/themes/assets/loaders/01.gif" class="w-100"/>
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
