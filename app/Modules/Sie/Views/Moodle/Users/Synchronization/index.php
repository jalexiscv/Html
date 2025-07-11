<?php

$mregistrations=model("App\Modules\Sie\Models\Sie_Registrations");

$registrations=$mregistrations->findAll();

$code="";
$code .= " <table\n";
$code .= "\t\t id=\"grid-table\"\n";
$code .= "\t\t class=\"table table-striped table-hover\" \n ";
$code .= "\t\t border=\"1\">\n";
$code .= "\t\t <thead>";
$code .= "\t\t\t\t  <tr>\n";
$code .= "\t\t\t\t\t\t <th class='text-center' title=\"\">#</th>\n";
$code .= "\t\t\t\t\t\t <th class='text-center' title=\"\">Cédula</th>\n";
$code .= "\t\t\t\t\t\t <th class='text-center' title=\"\">Nombres</th>\n";
$code .= "\t\t\t\t\t\t <th class='text-center' title=\"\">Apellidos</th>\n";
$code .= "\t\t\t\t\t\t <th class='text-center' title=\"\">Estado</th>\n";
$code .= "\t\t\t\t  </tr>\n";
$code .= "\t\t </thead>";
$code .= "\t\t <tbody>";

$count=0;
foreach ($registrations as $registration){
    $count++;
    $trid=@$registration["registration"];
    $identification_number=@$registration['identification_number'];
    $names=@$registration['first_name']."".@$registration['second_name']."".@$registration['first_surname']."".@$registration['second_surname'];
    $surnames=@$registration['first_surname']."".@$registration['second_surname'];
    // Fila
    $code .="\t\t\t\t  <tr id=\"trid-{$trid}\" data-registration=\"{$trid}\" data-status=\"STARTED\" >\n";
    $code .="\t\t\t\t\t <td class='text-center ' title=\"\" >{$count}</td>\n";
    $code .="\t\t\t\t\t <td class='text-center ' title=\"\" >{$identification_number}</td>\n";
    $code .="\t\t\t\t\t <td class='text-center ' title=\"\" >{$names}</td>\n";
    $code .="\t\t\t\t\t <td class='text-center ' title=\"\" >{$surnames}</td>\n";
    $code .="\t\t\t\t  </tr>\n";

}

$code .= "\t\t </tbody>";
$code .= "</table>";
echo($code);
?>
<script language="JavaScript">
    document.addEventListener('DOMContentLoaded', function () {
        const table = document.getElementById('grid-table');
        if (table) {
            const rows = table.querySelector('tbody').querySelectorAll('tr');
            const rowsToProcess = Array.from(rows).filter(row =>
                row.getAttribute('data-status') === 'STARTED'
            );
            processRowsSequentially(rowsToProcess, 0);
        } else {
            alert("No existe la tabla o su nombre es diferente");
        }

        function processRowsSequentially(rows, currentIndex) {
            if (currentIndex >= rows.length) {
                alert('Todas las filas han sido procesadas');
                return;
            }
            const currentRow = rows[currentIndex];
            const registration = currentRow.getAttribute('data-registration');
            //alert(`Procesando fila ${currentIndex + 1} de ${rows.length}`);
            callToApi(registration);
            setTimeout(() => {
                processRowsSequentially(rows, currentIndex + 1);
            },1000);
        }

        function callToApi(registration) {
            var timestamp = Date.now();
            const xhr = new XMLHttpRequest();
            const url = `/sie/api/moodle/json/users/${timestamp}?registration=${registration}`;

            // Agregar columna de estado si no existe
            const currentRow = document.querySelector(`tr[data-registration="${registration}"]`);
            let statusCell = currentRow.querySelector('.status-cell');
            if (!statusCell) {
                statusCell = document.createElement('td');
                statusCell.className = 'status-cell text-center';
                currentRow.appendChild(statusCell);
            }

            // Mostrar estado "Procesando"
            statusCell.innerHTML = '<span class="badge bg-warning">Procesando...</span>';

            xhr.open('GET', url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        statusCell.innerHTML = '<span class="badge bg-success">Completado</span>';
                    } else {
                        statusCell.innerHTML = '<span class="badge bg-danger">Error</span>';
                        console.error('Error:', xhr.statusText);
                    }
                }
            };

            xhr.send();
        }

    });
</script>
