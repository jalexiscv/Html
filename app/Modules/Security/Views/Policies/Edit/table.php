<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Security\Views\Roles\List\table.php]
*  ╩ ╩╝╚╝╚═╝╚═╝╩╚═╝╩═╝╚═╝
* -----------------------------------------------------------------------------
* Copyright 2021 - Higgs Bigdata S.A.S., Inc. <admin@Higgs.com>
* Este archivo es parte de Higgs Bigdata Framework 7.1
* Para obtener información completa sobre derechos de autor y licencia, consulte
* la LICENCIA archivo que se distribuyó con este código fuente.
* -----------------------------------------------------------------------------
* EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
* IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
* APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
* LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
* RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
* AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
* O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
* -----------------------------------------------------------------------------
* @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
* @link https://www.Higgs.com
* @Version 1.5.0
* @since PHP 7, PHP 8
* -----------------------------------------------------------------------------
* Datos recibidos desde el controlador - @ModuleController
* -----------------------------------------------------------------------------
* @Authentication
* @request
* @dates
* @view
* @oid
* @component
* @views
* @prefix
* @parent
* -----------------------------------------------------------------------------
*/


//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$mroles = model('App\Modules\Security\Models\Security_Roles');
$rol = $mroles->where("rol", $oid)->first();
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/security/users/list/" . lpk();
$table = $bootstrap->get_DynamicTable(array(
    'id' => 'table-' . lpk(),
    'data-url' => '/security/api/policies/json/list/' . $oid,
    'buttons' => array(//'create' => array('text' =>lang('App.Create'), 'href' => '/security/roles/create/'.lpk(), 'class' => 'btn-secondary'),
    ),
    'cols' => array(
        'status' => array('text' => lang('App.Status'), 'class' => 'text-center'),
        'permission' => array('text' => lang('App.Permission'), 'class' => 'text-center'),
        'alias' => array('text' => lang('App.Alias'), 'class' => 'text-start'),
        'module' => array('text' => lang('App.Module'), 'class' => 'text-center'),
    ),
    'data-page-size' => 100,
    'data-side-pagination' => 'server'
));
$info = $bootstrap->get_Alert(array('type' => 'info', 'title' => lang('App.Remember'), "message" => lang("Policies.list-info")));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang('Policies.list-title'),
    "header-back" => $back,
    "content" => $info . $table,
    "voice" => "security/policies-permissions-list.mp3",
));
echo($card);
?>
<script>
    //Código jquery para detectar cuándo se activa el checkbox
    function check_policie(status, value) {
        console.log("Status: " + status + " Value: " + value);
        var status = status;
        var permission = value;
        var rol = '<?php echo($oid); ?>';
        var ajaxURL = "/security/api/policies/json/edit/<?php echo($oid); ?>/<?php echo(lpk()); ?>";
        $.ajax({
            method: "POST",
            url: ajaxURL,
            data: {
                "rol": "<?php echo($oid); ?>",
                "permission": permission,
                "status": status,
                "<?php echo(csrf_token()); ?>": "<?php echo(csrf_hash()); ?>"
            }
        });
    }

</script>