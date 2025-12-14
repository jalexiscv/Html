<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                                                    2024-02-12 10:12:28
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Home\breadcrumb.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2024 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                                                                         consulte la LICENCIA archivo que se distribuyó con este código fuente.
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
//[vars]----------------------------------------------------------------------------------------------------------------
/** @var object $parent */
/** @var string $component */
/** @var string $view */
/** @var object $authentication */
/** @var object $request */
//[Services]-------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]---------------------------------------------------------------------------------------------------------------
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
$magreements = model('App\Modules\Sie\Models\Sie_Agreements');
$minstitutions = model('App\Modules\Sie\Models\Sie_Institutions');
$mcities = model('App\Modules\Sie\Models\Sie_Cities');
$mdiscounts = model("App\Modules\Sie\Models\Sie_Discounts");
$mdiscounteds = model("App\Modules\Sie\Models\Sie_Discounteds");
$mstatuses = model("App\Modules\Sie\Models\Sie_Statuses");
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");


if (!empty($program) && $program != "ALL") {
    $statuses = $mstatuses
            ->select('sie_statuses.*, sie_registrations.*')
            ->join('sie_registrations', 'sie_statuses.registration = sie_registrations.registration')
            ->groupBy('sie_statuses.registration')
            ->find();
} else {
    $statuses = $mstatuses
            ->select('sie_statuses.registration, sie_registrations.*')
            ->join('sie_registrations', 'sie_statuses.registration = sie_registrations.registration')
            ->groupBy('sie_statuses.registration')
            ->find();
}

$code = "";
$code .= " <table\n";
$code .= "\t\t id=\"excelTable\"\n";
$code .= "\t\t class=\"table table-responsive column-options\" \n ";
$code .= "\t\t border=\"1\">\n";
$code .= "<tdead>";
$code .= "<tr>\n";
$code .= "<td class='text-center ' title=\"\" >#</td>\n";
$code .= "<td class='text-center' title=\"\">Periodo</td>\n";
$code .= "<td class='text-center' title=\"\">Tipo</td>\n";
$code .= "<td class='text-center' title=\"\">Identificación</td>\n";
$code .= "<td class='text-center' title=\"\">Usuario</td>\n";
$code .= "<td class='text-center' title=\"\">Contraseña</td>\n";
$code .= "<td class='text-center' title=\"\">Nombre</td>\n";
$code .= "<td class='text-center' title=\"\">Apellido</td>\n";
$code .= "<td class='text-center' title=\"\">Correo Electrónico</td>\n";
$code .= "<td class='text-center' title=\"\">Teléfono</td>\n";
$code .= "<td class='text-center' title=\"\">WhatsApp</td>\n";
//$code .= "<td class='text-center' title=\"\">Correo Institucional</td>\n";
//$code .= "<td class='text-center' title=\"\">Correo Personal</td>\n";
$code .= "</tr>\n";
$code .= "</thead>";
$code .= "<tbody>";
$count = 0;
$class = "";

foreach ($statuses as $status) {
    $count++;
    $class = ($count % 2 == 0) ? "odd" : "even";
    $period = @$status['period'];
    //[vars]------------------------------------------------------------------------------------------------------------
    $registration = @$status['registration'];
    $identification_type = @$status['identification_type'];
    $identification_number = @$status['identification_number'];
    $password = substr(@$status['registration'], -6);
    $first_name = @$status['first_name'] . " " . @$status['second_name'];
    $last_name = @$status['first_surname'] . " " . @$status['second_surname'];

    $email_address = @$status['email_institutional'];
    $email_personal = @$status['email_address'];

    if (empty($email_address)) {
        //$email_address = @$status['email_address'];
    }

    $user = $email_address;

    $phone = @$status['phone'];
    $mobile = @$status['mobile'];

    $classbg = "";

    if (empty($email_address)) {
        $classbg = "bg-danger";
    }

    //[defaults]--------------------------------------------------------------------------------------------------------
    $code .= "<tr>";
    $code .= "    <td class='text-left text-nowrap {$classbg}'>{$count}</td>";
    $code .= "    <td class='text-left text-nowrap {$classbg}'>{$period}</td>";
    $code .= "    <td class='text-left text-nowrap {$classbg}'>{$identification_type}</td>";
    $code .= "    <td class='text-left text-nowrap {$classbg}'><a href=\"/sie/students/view/{$registration}\" target='_blank'>{$identification_number}</a></td>";
    $code .= "    <td class='text-left text-nowrap {$classbg}'>{$user}</td>";
    $code .= "    <td class='text-left text-nowrap {$classbg}'>{$password}</td>";
    $code .= "    <td class='text-left text-nowrap {$classbg}'>{$first_name}</td>";
    $code .= "    <td class='text-left text-nowrap {$classbg}'>{$last_name}</td>";
    $code .= "    <td class='text-left text-nowrap {$classbg}'>{$email_address}</td>";
    $code .= "    <td class='text-left text-nowrap {$classbg}'>{$phone}</td>";
    $code .= "    <td class='text-left text-nowrap {$classbg}'>{$mobile}</td>";
    //$code .= "    <td class='text-left text-nowrap '>{$email_address}</td>";
    //$code .= "    <td class='text-left text-nowrap '>{$email_personal}</td>";
    $code .= "</tr>";
}
$code .= "</tbody>";
$code .= "</table>";
//echo($code);
?>
<style>
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table th, .table td {
        padding: 0.5rem;
        vertical-align: middle;
    }

    .table thead th {
        border-bottom: 2px solid #dee2e6;
    }

    /* Para asegurar que las columnas se ajusten al contenido */
    .table {
        width: auto;
        max-width: none;
    }


    /* column options example */

    .column-options {
        border-collapse: collapse;
        border-bottom: 1px solid #d6d6d6;
        font-size: 13px;
    }

    .column-options th, .column-options td {
        font-family: Helvetica, Arial, sans-serif;
        font-weight: normal;
        color: #434343;
        background-color: #f7f7f7;
        border-left: 1px solid #ffffff;
        border-right: 1px solid #dcdcdc;
    }

    .column-options th {
        font-size: 140%;
        font-weight: normal;
        letter-spacing: 0.12em;
        text-shadow: -1px -1px 1px #999;
        color: #fff;
        background-color: #0cb08b;
        padding: 12px 0px 8px 0px;
        border-bottom: 1px solid #d6d6d6;
    }

    .column-options td {
        text-shadow: 1px 1px 0 #fff;
        padding: 3px 5px 3px 5px;
    }

    .column-options .odd td {
        background-color: #ededed;
    }


    .column-options th:first-child {
        border-top-left-radius: 7px;
        -moz-border-radius-topleft: 7px;
    }

    .column-options th:last-child {
        border-top-right-radius: 7px;
        -moz-border-radius-topright: 7px;
    }

    .column-options th:last-child, .column-options td:last-child {
        border-right: 0px;
    }

    .column-options a.button {
        font-size: 70%;
        text-shadow: none;
        text-decoration: none;
        text-align: center;
        text-shadow: -1px -1px 1px #72aebd;
        text-transform: uppercase;
        letter-spacing: 0.10em;
        color: #fff;
        padding: 7px 10px 4px 10px;
        border-radius: 5px;
        background-color: #00CC99;
        border-top: 1px solid #90f2da;
        border-right: 1px solid #00a97f;
        border-bottom: 1px solid #008765;
        border-left: 1px solid #7dd2bd;
        box-shadow: 2px 1px 2px #ccc;
        margin: 10px 5px 10px 5px;
        display: block;
    }

    .column-options a.button:hover {
        position: relative;
        top: 1px;
        left: 1px;
        background-color: #00CCFF;
        border-top: 1px solid #9aebff;
        border-right: 1px solid #08acd5;
        border-bottom: 1px solid #07a1c8;
        border-left: 1px solid #92def1;
        box-shadow: -1px -1px 2px #ccc;
    }

    .selected {
        background-color: #f0f8ff; /* Color de fondo ligeramente más oscuro */
    }

</style>
<?php echo($code); ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const table = document.getElementById('excelTable');

        // Funcionalidad de selección de celdas
        table.addEventListener('click', (e) => {
            if (e.target.tagName === 'TD') {
                // Remover selección previa
                table.querySelectorAll('td.selected').forEach(cell => {
                    cell.classList.remove('selected');
                });

                // Agregar selección a la celda actual
                e.target.classList.add('selected');
            }
        });

        // Opcional: Navegación con teclas
        table.addEventListener('keydown', (e) => {
            const cell = e.target;
            if (cell.tagName === 'TD') {
                let newCell;
                switch (e.key) {
                    case 'ArrowDown':
                        newCell = cell.closest('tr').nextElementSibling?.children[cell.cellIndex];
                        break;
                    case 'ArrowUp':
                        newCell = cell.closest('tr').previousElementSibling?.children[cell.cellIndex];
                        break;
                    case 'ArrowRight':
                        newCell = cell.nextElementSibling;
                        break;
                    case 'ArrowLeft':
                        newCell = cell.previousElementSibling;
                        break;
                }

                if (newCell) {
                    table.querySelectorAll('td.selected').forEach(c => c.classList.remove('selected'));
                    newCell.classList.add('selected');
                    newCell.focus();
                }
            }
        });


    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>