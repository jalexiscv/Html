<?php
//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$musers = model('App\Modules\Security\Models\Security_Users_Fields');
$alias = $musers->get_Field($oid, "alias");
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/security/users/list/" . lpk();
$table = $bootstrap->get_DynamicTable(array(
    'id' => 'table-' . lpk(),
    'data-url' => "/security/api/hierarchies/json/list/{$oid}?t=" . lpk(),
    'buttons' => array(//'create' => array('text' =>lang('App.Create'), 'href' => '/security/roles/create/'.lpk(), 'class' => 'btn-secondary'),
    ),
    'cols' => array(
        'check' => array('text' => "", 'class' => 'text-center fit px-2'),
        'rol' => array('text' => lang('App.Rol'), 'class' => 'text-center', "visible" => false),
        'name' => array('text' => lang('App.Name'), 'class' => 'text-start px-2'),
        'description' => array('text' => lang('App.Description'), 'class' => 'text-start px-2', "visible" => false),
        'options' => array('text' => lang('App.Options'), 'class' => 'text-center fit px-2'),
    ),
    'data-page-size' => 100,
    'data-side-pagination' => 'server'
));

$info = $bootstrap->get_Alert(array('type' => 'info', 'title' => lang('App.Remember'), "message" => lang("Hierarchies.list-info")));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang('Security.hierarchies-roles-list'),
    "header-back" => $back,
    "content" => $info . $table,
    "voice" => "security/hierarchies-roles-list.mp3",
));
echo($card);
?>
<script>
    //Código jquery para detectar cuándo se activa el checkbox
    function check_hierarchie(status, value) {
        console.log("Status: " + status + " Value: " + value);
        var status = status;
        var rol = value;
        var user = '<?php echo($oid); ?>';
        var ajaxURL = "/security/api/hierarchies/json/edit/<?php echo($oid); ?>/<?php echo(lpk()); ?>";
        $.ajax({
            method: "POST",
            url: ajaxURL,
            data: {
                "user": "<?php echo($oid); ?>",
                "rol": rol,
                "status": status,
                "<?php echo(csrf_token()); ?>": "<?php echo(csrf_hash()); ?>"
            }
        });
    }
</script>
