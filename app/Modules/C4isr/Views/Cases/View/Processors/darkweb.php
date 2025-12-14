<?php
/*
 * Copyright (c) 2023. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

// AccountOverview
// Account Level 	Small Business
// API Key 	ApWJ249AiARJ8PrEIPm6ZuGLrEV0wqdg
// Display Name 	SHODANADMIN
// Email 	shodan.mil@gmail.com
// Member 	Yes
$b = service("bootstrap");
$s = service('strings');
$f = service("forms", array("lang" => "Cases."));

$explore = $f->get_Value("explore", "");
$html = "";

$case = $f->get_Value("case", "");
$type = $f->get_Value("type", "");
$explore = $f->get_Value("explore", "");
$query = $f->get_Value("query", "");

echo("<div class=\"row p-3\">");
echo("    <div class=\"col-auto\">");
echo("        <img src=\"/themes/assets/images/cd.gif\" style=\"width: 100px;\">");
echo("    </div>");
echo("    <div class=\"col\">");
echo("        <span><b>Consulta</b>: " . $query . "</span>");
echo("        <br><span id='msg-tor'><b>Tor(The Onion Router)</b>: Iniciando...</span>");
echo("        <br><span id='msg-position'><b>Aproximadamente</b>: Calculando...</span>");
echo("    </div>");
echo("</div>");


?>

<table id="table-darkweb" class="table table-bordered">
    <thead>
    <tr>
        <th class="text-center">Linea</th>
        <th class="text-center">Archivo</th>
        <th class="text-center">Opciones</th>
    </tr>
    </thead>
</table>

<style>
    .context {
        line-height: 1rem;
        font-size: 1rem;
        border: 1px solid #cccccc !important;
        background-color: #e9eaed !important;
        overflow: scroll;
        padding: 1rem !important;
        width: 600px !important;
    }

    .highlight {
        background-color: #6dbd60;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
<script>
    let next = ""; // valor inicial de 'next'

    function getData(callback) {
        let xhr = new XMLHttpRequest();
        xhr.open('GET', '/c4isr/prolian/stream/<?php echo(lpk());?>?next=' + next + '&query=<?php echo($query);?>');
        xhr.onload = function () {
            if (xhr.status === 200) {
                let json = JSON.parse(xhr.responseText);
                callback(json);
                // actualizamos el valor de 'next' para la próxima solicitud
                next = json.next;
                if (next != "" && next != null) {
                    getData(function (json) {
                        let results = json.results;
                        addRow(results);
                    });
                    var hashMD5 = CryptoJS.MD5(next.toLowerCase()).toString();
                    msgTOR("<b>Tor(The Onion Router)</b>: " + hashMD5 + ".onion");
                    msgPosition("<b>Explorando</b>: " + json.position + "/" + json.total + " Nodos");
                } else {
                    msgTOR("No hay mas resultados");
                }
            }
        };
        xhr.send();
    }

    function msgTOR(msg) {
        var spanElement = document.getElementById("msg-tor");
        spanElement.innerHTML = msg;
    }


    function msgPosition(msg) {
        var spanElement = document.getElementById("msg-position");
        spanElement.innerHTML = msg;
    }

    function addRow(results) {
        let table = document.getElementById("table-darkweb");
        for (let result of results) {
            let context = "<a href=\"#\" target=\"_blank\" class=\"pt-1 py-1\">" + result.file + "</a>";
            context += "<div class=\"context\">" + urldecode(result.context) + "</div>";
            let hl = highlight(context, '<?php echo($query);?>');
            let newRow = table.insertRow();
            let cell1 = newRow.insertCell(0);
            cell1.classList.add('text-center');
            cell1.classList.add('border-1');
            cell1.innerHTML = result.line;
            let cell2 = newRow.insertCell(1);
            cell2.classList.add('text-start');
            cell2.classList.add('p-3');
            cell2.innerHTML = hl;
            table.appendChild(newRow);
            let cell3 = newRow.insertCell(2);
            cell3.classList.add('text-center');
            cell3.classList.add('border-1');
            cell3.innerHTML = urldecode(result.options);
            table.appendChild(newRow);
        }
    }

    function highlight(text, search) {
        let regex = new RegExp(search, 'gi');
        let result = text.replace(regex, '<span class="highlight">$&</span>');
        return result;
    }

    function urldecode(str) {
        let result = decodeURIComponent(str.replace(/\+/g, ' '));
        return result;
    }

    getData(function (json) {
        let results = json.results;
        addRow(results);
    });

    document.addEventListener('show.bs.modal', function (event) {
        // Obtenemos la ruta del iframe del botón que activó el modal
        const button = event.relatedTarget;
        const iframeSrc = button.getAttribute('data-src');

        // Actualizamos la ruta del iframe dentro del modal
        const iframe = document.querySelector('#onion iframe');
        iframe.src = iframeSrc;
    });


</script>
<div class="modal" id="onion" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Contenidos de la ventana modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="miModalLabel">Historial</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <iframe src="" frameborder="0" style="width: 100%; height: 400px;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continuar</button>
            </div>
        </div>
    </div>
</div>