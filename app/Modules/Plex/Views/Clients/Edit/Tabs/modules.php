<?php
$mmodules = model("App\Modules\Plex\Models\Plex_Modules", true);
$mmodules = model('App\Modules\Plex\Models\Plex_Modules');
$mClientsXModules = model('App\Modules\Plex\Models\Plex_Clients_Modules');
$modules = $mmodules->get_List(1000, 0);
$code = "<table class=\"table table-bordered table-striped\">";
$code .= "<tr>";
$code .= "   <th class=\"text-center align-middle\" >#</th>";
//$code.="   <th>Alias</th>";
$code .= "   <th>Nombre</th>";
$code .= "<tr>";
foreach ($modules as $module) {
    $title=lang("Modules.".$module['title']);
    $span = html()::tag('span');
    $span->attr('class', 'slider round');
    $span->content(array());
    $authorization = $mClientsXModules
        ->where("client", $oid)
        ->where("module", $module["module"])
        ->orderBy("authorization", "ASC")
        ->first();
    $input = html()::tag('input');
    $input->attr('name', 'authorization');
    $input->attr('id', 'authorization');
    $input->attr('class', 'checkbox success');
    $input->attr('type', 'checkbox');
    $input->attr('data-module', $module["module"]);
    $input->attr('onchange', 'check_module_client(this)');
    if ($authorization) {
        $input->attr('checked', 'true');
    }
    $status = html()::tag('label');
    $status->attr('class', 'switch');
    $status->content(array($input, $span));
    $options = html()::tag('div');
    $options->attr('class', 'btn-group');
    $options->attr('role', 'group');
    $options->content(array($status));
    $checkbox = "";
    $code .= "<tr>";
    $code .= "   <td class=\"text-center align-middle\">{$options}</td>";
    //$code.="   <td>{$module['module']}</td>";
    $code .= "   <td>{$title}</td>";
    $code .= "<tr>";
}
$code .= "</table>";
echo($code);
?>
<script>
    function check_module_client(element) {
        var client = '<?php echo($oid); ?>';
        var module = element.getAttribute('data-module');
        var status = element.checked;
        //console.log("Status: " + status + " Value: " + value);
        var url = "/plex/api/authorizations/json/edit/<?php echo($oid); ?>";
        var form = new FormData();
        form.append("client", client);
        form.append("module", module);
        form.append("status", status);
        form.append("<?php echo(csrf_token()); ?>", "<?php echo(csrf_hash()); ?>");
        fetch(url, {
            method: "POST",
            body: form
        }).then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        }).then(data => {
            console.log(data);
        }).catch(error => {
            console.error('There has been a problem with your fetch operation:', error);
        });
    }


</script>