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
//[vars]----------------------------------------------------------------------------------------------------------------
$limit = 100; // Registros por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if (!empty($program) && $program != "ALL") {
    $statuses = $mstatuses
            ->select('sie_statuses.*, sie_registrations.*')
            ->join('sie_registrations', 'sie_statuses.registration = sie_registrations.registration')
            ->groupBy('sie_statuses.registration')
            ->limit(100, 0)
            ->find();
} else {
    $statuses = $mstatuses
            ->select('sie_statuses.registration, sie_registrations.*')
            ->join('sie_registrations', 'sie_statuses.registration = sie_registrations.registration')
            ->groupBy('sie_statuses.registration')
            ->limit(100, 0)
            ->find();
}

$code = "";
$code .= "<table\n";
$code .= "\t\t id=\"excelTable\"\n";
$code .= "\t\t class=\"table table-striped table-hover\" \n ";
$code .= "\t\t border=\"1\">\n";
$code .= "<tdead>";
$code .= "<tr>\n";
$code .= "<td class='text-center ' title=\"\" >#</td>\n";
$code .= "<td class='text-center' title=\"\">Periodo</td>\n";
$code .= "<td class='text-center' title=\"\">Tipo</td>\n";
$code .= "<td class='text-center' title=\"\">Identificación</td>\n";
$code .= "<td class='text-center' title=\"\">Usuario</td>\n";
$code .= "<td class='text-center' title=\"\">Contraseña</td>\n";
$code .= "<td class='text-center' title=\"\">Usuario</td>\n";
$code .= "<td class='text-center' title=\"\">Matricula</td>\n";
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

    $user = "";
    $matricula = "";

    $email_address = @$status['email_institutional'];
    if (empty($email_address)) {
        //$email_address = @$status['email_address'];
    } else {
        $user = $mfields->get_UserByEmail($email_address);
        $matricula = $mfields->get_Field($user, "sie-registration");
    }

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
    $code .= "    <td class='text-left text-nowrap {$classbg}'>{$email_address}</td>";
    $code .= "    <td class='text-left text-nowrap {$classbg}'>{$password}</td>";
    $code .= "    <td class='text-left text-nowrap {$classbg}'>{$user}</td>";
    $code .= "    <td class='text-left text-nowrap {$classbg}'>{$matricula}</td>";
    $code .= "</tr>";
}
$code .= "</tbody>";
$code .= "</table>";
$code .= "<div class=\"pagination-container py-2\">";
include("pagination.php");
$code .= "</div>";
//echo($code);
?>
<?php include("styles.php"); ?>
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