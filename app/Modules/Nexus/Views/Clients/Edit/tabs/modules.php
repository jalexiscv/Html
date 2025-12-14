<?php
$mmodules = model("App\Modules\Nexus\Models\Nexus_Modules", true);
$table = array(
    'id' => 'table-' . lpk(),
    'data-url' => '/nexus/api/authorizations/json/list/' . $oid,
    'buttons' => array(//'create' => array('text' =>lang('App.Create'), 'href' => '/security/roles/create/'.lpk(), 'class' => 'btn-secondary'),
    ),
    'cols' => array(
        'options' => array('text' => Lang("App.Status"), 'class' => 'text-center'),
        'module' => array('text' => lang('App.Module'), 'class' => 'text-center', "visible" => false),
        'alias' => array('text' => lang('App.Name'), 'class' => 'text-center'),
        'description' => array('text' => lang('App.Description'), 'class' => 'text-center'),
    ),
    'data-page-size' => 50,
    'data-side-pagination' => 'server'
);
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
$smarty = service('smarty');
$smarty->set_Mode('bs5x');
$smarty->assign('table', $table);
$smarty->assign('file', __FILE__);
echo($smarty->view('components/tables/index.tpl'));
?>
<script>
    //Código jquery para detectar cuándo se activa el checkbox
    function check_module_client(status, value) {
        console.log("Status: " + status + " Value: " + value);
        var status = status;
        var module = value;
        var user = '<?php echo($oid); ?>';
        var ajaxURL = "/nexus/api/authorizations/json/edit/<?php echo($oid); ?>/<?php echo(lpk()); ?>";
        $.ajax({
            method: "POST",
            url: ajaxURL,
            data: {
                "client": "<?php echo($oid); ?>",
                "module": module,
                "status": status,
                "<?php echo(csrf_token()); ?>": "<?php echo(csrf_hash()); ?>"
            }
        });
    }

</script>