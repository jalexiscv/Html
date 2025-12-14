<?php
/*
 * Copyright (c) 2023. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */
$s = service('strings');
$f = service("forms", array("lang" => "Cases.darkweb_"));
//[Request]-----------------------------------------------------------------------------
$mcountries = model('App\Modules\C4isr\Models\C4isr_Countries');

$row = $model->find($oid);
$r["case"] = $row["case"];
$r["country"] = $f->get_Value("country", "CO");
$r["vulnerability"] = $f->get_Value("vulnerability", "CO");
$r["authentication"] = $f->get_Value("authentication", "FTP");
$r["service"] = $f->get_Value("service", "all");
$r["domain"] = $f->get_Value("domain", "");
$r["type"] = $row["type"];


$r["explore"] = "";
$r["variant"] = "";

$type = $s->get_Strtolower($row["type"]);
$back = "/c4isr/cases/home/{$type}/" . lpk();
//[Fields]-----------------------------------------------------------------------------
$f->add_HiddenField("case", $r["case"]);
$f->add_HiddenField("type", $r["type"]);
$f->add_HiddenField("explore", "query");
$f->fields["case"] = $f->get_FieldView("case", array("value" => $r["case"], "proportion" => "col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12", "readonly" => true));
$f->fields["query"] = $f->get_FieldText("query", array("value" => $r["domain"], "proportion" => "col-xl-7 col-lg-7 col-md-10 col-sm-12 col-12 required"));
$f->fields["submit"] = $f->get_FieldSubmit("submit", array("href" => "/c4isr/cases/edit/" . $oid, "value" => lang("App.Search"), "class" => "btn btn-secondary", "proportion" => "col-xl-2 col-lg-2 col-md-12 col-sm-12 col-12"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["case"] . $f->fields["query"] . $f->fields["submit"])));
echo($f);
//[View]------------------------------------------------------------------------------
$sumitid = $f->get_FieldId("submit");
$fexplore = $f->get_FieldId("explore");
$fvariant = $f->get_FieldId("variant");
$fdomain = $f->get_FieldId("domain");
?>
<script>
    var fvariant = document.getElementById('<?php echo($fvariant);?>');
    var fdomain = document.getElementById('<?php echo($fdomain);?>');
    fdomain.disabled = true;
    fvariant.disabled = true;


    const fexplore = document.getElementById('<?php echo($fexplore);?>');
    fexplore.addEventListener('change', function () {
        var $option = this.value;
        var fvariant = document.getElementById('<?php echo($fvariant);?>');
        var fdomain = document.getElementById('<?php echo($fdomain);?>');
        var ldomain = document.getElementById('<?php echo($fdomain);?>_label');

        // Elimina todas las opciones existentes
        while (fvariant.firstChild) {
            fvariant.removeChild(fvariant.firstChild);
        }

        if ($option == "vulnerability") {
            const vulnerabilities = [
                {value: 'eternalblue', text: 'EternalBlue'},
                {value: 'bluekeep', text: 'BlueKeep'},
                {value: 'proxylogon', text: 'ProxyLogon'},
                {value: 'proxyshell', text: 'ProxyShell'},
            ];
            vulnerabilities.forEach(function (vulnerability) {
                var option = document.createElement("option");
                option.value = vulnerability.value;
                option.text = vulnerability.text;
                fvariant.add(option);
            });
            fdomain.disabled = false;
            fvariant.disabled = false;
        } else if ($option == "authentication") {
            const authentications = [
                {value: 'ftp', text: 'File Transfer Protocol(FTP)'},
                {value: 'rfb', text: 'Remote Framebuffer(RFB)'},
                {value: 'vnc', text: 'Virtual Network Computing(VNC)'},
            ];
            authentications.forEach(function (authentication) {
                var option = document.createElement("option");
                option.value = authentication.value;
                option.text = authentication.text;
                fvariant.add(option);
            });
            fdomain.disabled = false;
            fvariant.disabled = false;
        } else if ($option == "service") {
            const services = [
                {"value": "ssh", "text": "Secure Shell (SSH)"},
                {"value": "web", "text": "Web"},
                {"value": "ftp", "text": "File Transfer Protocol (FTP)"},
                {"value": "mysql", "text": "MySQL"},
                {"value": "rdp", "text": "Remote Desktop Protocol (RDP)"},
                {"value": "all", "text": "All Services"}
            ];
            services.forEach(function (service) {
                var option = document.createElement("option");
                option.value = service.value;
                option.text = service.text;
                fvariant.add(option);
            });
            fdomain.disabled = false;
            fvariant.disabled = false;
        } else if ($option == "domain") {
            ldomain.innerHTML = "Dominio";
            fdomain.disabled = false;
            fvariant.disabled = true;
            fdomain.placeholder = "Ej: mil.co";
        } else if ($option == "ip") {
            ldomain.innerHTML = "IP";
            fdomain.disabled = false;
            fvariant.disabled = true;
            fdomain.placeholder = "Ej: 127.0.0.1";
        }
    });
</script>


<script>
    const fsumitid = document.getElementById('<?php echo($sumitid);?>');
    fsumitid.addEventListener('click', function () {
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
            "Buscando vulnerabilidades utilizando la base de datos CVE",
            "Recopilando información de vulnerabilidades del sistema de gestión de firewalls B",
            "Realizando una búsqueda de vulnerabilidades en el sistema de prevención de intrusiones C",
            "Obteniendo datos de alta prioridad de vulnerabilidades del sistema de gestión de seguridad D",
            "Procesando datos de vulnerabilidades del sistema de análisis de seguridad E",
            "Encontrando vulnerabilidades de usuarios en el sistema de gestión de identidad y acceso F",
            "Recopilando información de vulnerabilidades del sistema de detección de amenazas G",
            "Solicitando datos de vulnerabilidades del sistema de autenticación de usuarios H",
            "Buscando vulnerabilidades en el sistema de gestión de parches I utilizando la base de datos CVE",
            "Obteniendo información de vulnerabilidades de la pen-tester automatizado J",
            "Buscando vulnerabilidades históricas del sistema de retención de registros de seguridad K utilizando la base de datos CVE",
            "Obteniendo estadísticas de vulnerabilidades del sistema de análisis de riesgos L",
            "Obteniendo información de vulnerabilidades de la nube del sistema de seguridad de la infraestructura M",
            "Buscando vulnerabilidades de incidencias del sistema de respuesta ante incidentes N utilizando la base de datos CVE",
            "Procesando solicitudes de vulnerabilidades del sistema de administración de incidentes O",
            "Consultando la base de conocimientos de vulnerabilidades del sistema de monitoreo de red P",
            "Buscando vulnerabilidades mediante análisis de datos del sistema de gestión de riesgos Q",
            "Generando reporte de vulnerabilidades del sistema de auditoría de seguridad R",
            "Obteniendo información de vulnerabilidades de la red del sistema de firewall de próxima generación S",
            "Recopilando datos de vulnerabilidades de la API del sistema de gestión de claves T",
            "Generando reporte de vulnerabilidades de desempeño del sistema de monitoreo de seguridad U",
            "Consultando información de vulnerabilidades y seguridad del sistema de gestión de la seguridad de la información V",
            "Procesando solicitudes de vulnerabilidades y soporte del sistema de gestión de incidentes de seguridad W",
            "Consultando datos de vulnerabilidades de proyectos del sistema internacional",
            "Generando reporte de vulnerabilidades de seguridad regional",
            "Obteniendo información de sistema de automatización de defensa cibernética"
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

