<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-09-16 16:33:22
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Subsectors\List\table.php]
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
 * █ @link https://www.higgs.com.co
 * █ @Version 1.5.1 @since PHP 8,PHP 9
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
/**
 * @var object $authentication Authentication service from the ModuleController.
 * @var object $bootstrap Instance of the Bootstrap class from the ModuleController.
 * @var string $component Complete URI to the requested component.
 * @var object $dates Date service from the ModuleController.
 * @var string $oid String representing the object received, usually an object/data to be viewed, transferred from the ModuleController.
 * @var object $parent Represents the ModuleController.
 * @var object $request Request service from the ModuleController.
 * @var object $strings String service from the ModuleController.
 * @var string $view String passed to the view defined in the viewer for evaluation.
 * @var string $viewer Complete URI to the view responsible for evaluating each requested view.
 * @var string $views Complete URI to the module views.
 **/
//[models]--------------------------------------------------------------------------------------------------------------
$msubsectors = model('App\Modules\Sie\Models\Sie_Subsectors');
$msettings = model("App\Modules\Sie\Models\Sie_Settings");
//[vars]----------------------------------------------------------------------------------------------------------------
$moodle_url = $msettings->getSetting("MOODLE-URL");
$back = "/sie/networks/list/" . lpk();
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$fields = array(
    //"subsector" => lang("App.subsector"),
    //"network" => lang("App.network"),
    //"reference" => lang("App.reference"),
    //"name" => lang("App.name"),
    //"description" => lang("App.description"),
    //"created_by" => lang("App.created_by"),
    //"updated_by" => lang("App.updated_by"),
    //"deleted_by" => lang("App.deleted_by"),
    //"created_at" => lang("App.created_at"),
    //"updated_at" => lang("App.updated_at"),
    //"deleted_at" => lang("App.deleted_at"),
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array(
        "network" => $oid
);
//$msubsectors->clear_AllCache();
$rows = $msubsectors->getCachedSearch($conditions, $limit, $offset, "subsector DESC");
$total = $msubsectors->getCountAllResults($conditions);
//echo(safe_dump($rows['sql']));
//[build]--------------------------------------------------------------------------------------------------------------
$bgrid = $bootstrap->get_Grid();
$bgrid->set_Total($total);
$bgrid->set_Limit($limit);
$bgrid->set_Offset($offset);
$bgrid->set_Class("P-0 m-0");
$bgrid->set_Limits(array(10, 20, 40, 80, 160, 320, 640, 1200, 2400));
$bgrid->set_Headers(array(
        array("content" => "#", "class" => "text-center	align-middle"),
        array("content" => lang("App.Subsector"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.network"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.reference"), "class" => "text-center	align-middle"),
        array("content" => lang("App.Name"), "class" => "text-center	align-middle"),
        array("content" => "Curso Base (Moodle)", "class" => "text-center	align-middle"),
    //array("content" => lang("App.description"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_by"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_by"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_by"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
        array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/sie/subsectors';
$count = $offset;
foreach ($rows["data"] as $row) {
    if (!empty($row["subsector"])) {
        $count++;
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "$component/view/{$row["subsector"]}";
        $hrefEdit = "$component/edit/{$row["subsector"]}";
        $hrefDelete = "$component/delete/{$row["subsector"]}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-sm btn-primary ml-1",));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-sm btn-warning ml-1",));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-sm btn-danger ml-1",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnView . $btnEdit . $btnDelete));
        //[etc]---------------------------------------------------------------------------------------------------------

        $link = "<a href=\"#\" onclick=\"confirmMoodleAccess('" . $row['moodle_course_base'] . "'); return false;\" class=\"text-primary fw-bold\">{$row['moodle_course_base']}<i class=\"fas fa-external-link-alt ms-1\"></i></a>";
        $bgrid->add_Row(
                array(
                        array("content" => $count, "class" => "text-center align-middle"),
                        array("content" => $row['subsector'], "class" => "text-left align-middle"),
                    //array("content" => $row['network'], "class" => "text-left align-middle"),
                    //array("content" => $row['reference'], "class" => "text-left align-middle"),
                        array("content" => $row['name'], "class" => "text-left align-middle"),
                        array("content" => $link, "class" => "text-center align-middle"),
                    //array("content" => $row['description'], "class" => "text-left align-middle"),
                    //array("content" => $row['created_by'], "class" => "text-left align-middle"),
                    //array("content" => $row['updated_by'], "class" => "text-left align-middle"),
                    //array("content" => $row['deleted_by'], "class" => "text-left align-middle"),
                    //array("content" => $row['created_at'], "class" => "text-left align-middle"),
                    //array("content" => $row['updated_at'], "class" => "text-left align-middle"),
                    //array("content" => $row['deleted_at'], "class" => "text-left align-middle"),
                        array("content" => $options, "class" => "text-center align-middle"),
                )
        );
    }
}
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("card-grid", array(
        "header-title" => lang('Sie_Subsectors.list-title'),
        "header-back" => $back,
        "header-add" => "/sie/subsectors/create/" . $oid,
        "alert" => array("icon" => ICON_INFO, "type" => "info", "title" => lang('Sie_Subsectors.list-title'), "message" => lang('Sie_Subsectors.list-description')),
        "content" => $bgrid,
));
echo($card);
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnCreate = document.getElementById('btn-create-moodle');
        const btnSync = document.getElementById('btn-sync-moodle');
        const loadingOverlay = document.getElementById('loading-overlay');
        const loadingMessage = document.getElementById('loading-message');
        const statusDiv = document.getElementById('moodle-status');

        // Variables para el modal de acceso a Moodle
        const moodleAccessModal = new bootstrap.Modal(document.getElementById('moodleAccessModal'));
        const confirmMoodleAccessBtn = document.getElementById('confirmMoodleAccessBtn');
        let currentMoodleCourseId = null;


        // Función para confirmar acceso a Moodle
        window.confirmMoodleAccess = function (courseId) {
            currentMoodleCourseId = courseId;

            // Reproducir audio de advertencia
            try {
                const audio = new Audio('/themes/assets/audios/sie/es-courses-view-moodle-link.mp3');
                audio.play().catch(function (error) {
                    console.log('No se pudo reproducir el audio de advertencia:', error);
                });
            } catch (error) {
                console.log('Error al crear el objeto de audio:', error);
            }

            moodleAccessModal.show();
        };

        // Event listener para el botón de confirmación del modal
        confirmMoodleAccessBtn.addEventListener('click', function () {
            if (currentMoodleCourseId) {
                const moodleUrl = `<?php echo($moodle_url["value"]); ?>/course/view.php?id=${currentMoodleCourseId}`;
                window.open(moodleUrl, '_blank');
                moodleAccessModal.hide();
                currentMoodleCourseId = null;
            }
        });
    });
</script>
<!-- Modal de advertencia para acceso a Moodle -->
<div class="modal fade" id="moodleAccessModal" tabindex="-1" aria-labelledby="moodleAccessModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="moodleAccessModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Advertencia - Acceso a Moodle
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Importante:</strong> Estás a punto de acceder al curso en Moodle.
                </div>
                <p class="mb-3">
                    Para poder ver y administrar el curso correctamente, necesitas:
                </p>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Tener Moodle abierto en otra pestaña
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Estar logueado como <strong>administrador</strong>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Tener permisos de administración activos
                    </li>
                </ul>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Si no cumples estos requisitos, <strong>cancela</strong> e inicia sesión como administrador
                    antes de continuar.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>
                    Cancelar
                </button>
                <button type="button" class="btn btn-primary" id="confirmMoodleAccessBtn">
                    <i class="fas fa-external-link-alt me-2"></i>
                    Continuar a Moodle
                </button>
            </div>
        </div>
    </div>
</div>
