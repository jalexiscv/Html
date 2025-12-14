<?php
$mcenters = model('App\Modules\Sgd\Models\Sgd_Centers');

$centers = $mcenters->get_SelectData();
?>

<form id="documentManagementForm" class="form-inline w-100 mb-3">
    <table class="table-responsive  w-100">
        <tr>
            <td class="text-md-center">Centro</td>
            <td class="text-md-center">Estante</td>
            <td class="text-md-center">Caja</td>
            <td class="text-md-center">Carpeta</td>
            <td class="text-md-center">Acción</td>
        </tr>
        <tr>

            <td>
                <div class="form-group mr-3">
                    <select class="form-control" id="centerSelect" name="center">
                        <option value="">Seleccione uno</option>
                        <?php foreach ($centers as $center): ?>
                            <option value="<?php echo($center["value"]); ?>"><?php echo($center["label"]); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </td>
            <td>
                <div class="form-group mr-3">
                    <select class="form-control" id="shelveSelect" name="shelve">
                        <option value="">Seleccione un estante</option>
                    </select>
                </div>
            </td>

            <td>
                <div class="form-group mr-3">
                    <select class="form-control" id="boxSelect" name="box">
                        <option value="">Seleccione una caja</option>
                    </select>
                </div>
            </td>
            <td>
                <div class="form-group mr-3">
                    <select class="form-control" id="folderSelect" name="folder">
                        <option value="">Seleccione una carpeta</option>
                    </select>
                </div>
            </td>
            <td class="text-md-center">
                <div class="form-group">
                    <button type="button" class="btn btn-primary w-100" id="updateButton">Actualizar</button>
                </div>
            </td>
        </tr>
    </table>
</form>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const centerSelect = document.getElementById('centerSelect');
        const shelveSelect = document.getElementById('shelveSelect');
        const boxSelect = document.getElementById('boxSelect');
        const folderSelect = document.getElementById('folderSelect');
        const updateButton = document.getElementById('updateButton');

        centerSelect.addEventListener('change', function () {
            var selected = centerSelect.options[centerSelect.selectedIndex].value;
            var url = '/sgd/api/shelves/json/list/' + selected;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    shelveSelect.innerHTML = '<option value="">Seleccione un estante</option>';
                    data.forEach(function (item) {
                        var option = document.createElement('option');
                        option.value = item.value;
                        option.text = item.label;
                        shelveSelect.appendChild(option);
                    });
                });
        });

        shelveSelect.addEventListener('change', function () {
            var selected = shelveSelect.options[shelveSelect.selectedIndex].value;
            var url = '/sgd/api/boxes/json/list/' + selected;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    boxSelect.innerHTML = '<option value="">Seleccione una caja</option>';
                    data.forEach(function (item) {
                        var option = document.createElement('option');
                        option.value = item.value;
                        option.text = item.label;
                        boxSelect.appendChild(option);
                    });
                });
        });

        boxSelect.addEventListener('change', function () {
            var selected = boxSelect.options[boxSelect.selectedIndex].value;
            var url = '/sgd/api/folders/json/list/' + selected;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    folderSelect.innerHTML = '<option value="">Seleccione una carpeta</option>';
                    data.forEach(function (item) {
                        var option = document.createElement('option');
                        option.value = item.value;
                        option.text = item.label;
                        folderSelect.appendChild(option);
                    });
                });
        });



        // Update button logic
        updateButton.addEventListener('click', function () {
            var url = '/sgd/api/locations/json/create/'+'<?php echo($oid); ?>';
            const formData = {
                registration: '<?php echo($oid); ?>',
                center: centerSelect.value,
                shelve: shelveSelect.value,
                box: boxSelect.value,
                folder: folderSelect.value
            };
            console.log('Datos a actualizar:', formData);
            const isValid = Object.values(formData).every(value => value !== '');
            if (isValid) {
                // Enviar los datos al servidor
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(formData)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            alert('Los datos se han guardado correctamente');
                            // Opcional: recargar la p��gina o actualizar la vista
                            // window.location.reload();
                        } else {
                            alert('Error al guardar los datos: ' + (data.message || 'Error desconocido'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al procesar la solicitud');
                    });
            } else {
                alert('Por favor, complete todos los campos');
            }
        });
    });
</script>


<?php

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
$mlocations = model('App\Modules\Sgd\Models\Sgd_Locations');
//[vars]----------------------------------------------------------------------------------------------------------------
$back= "/sgd";
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$fields = array(
    //"location" => lang("App.location"),
    //"center" => lang("App.center"),
    //"shelve" => lang("App.shelve"),
    //"box" => lang("App.box"),
    //"folder" => lang("App.folder"),
    //"author" => lang("App.author"),
    //"date" => lang("App.date"),
    //"time" => lang("App.time"),
    //"created_at" => lang("App.created_at"),
    //"updated_at" => lang("App.updated_at"),
    //"deleted_at" => lang("App.deleted_at"),
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array(
        "registration="=>$oid
);
//$mlocations->clear_AllCache();
$rows = $mlocations->get_CachedSearch($conditions,$limit, $offset,"location DESC");
// Error complejo revisar a penas se pueda
$total =0;//$mlocations->get_CountAllResults($conditions);
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
    array("content" => "Código", "class" => "text-center	align-middle"),
    array("content" => "Centro", "class" => "text-center	align-middle"),
    array("content" => "Estante", "class" => "text-center	align-middle"),
    array("content" => "Caja", "class" => "text-center	align-middle"),
    array("content" => "Carpeta", "class" => "text-center	align-middle"),
    array("content" => lang("App.Author"), "class" => "text-center	align-middle"),
    array("content" => lang("App.date"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.time"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/sgd/locations';
$count = $offset;
foreach ($rows["data"] as $row) {
    if(!empty($row["location"])){
        $count++;
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView="$component/view/{$row["location"]}";
        $hrefEdit="$component/edit/{$row["location"]}";
        $hrefDelete="$component/delete/{$row["location"]}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm","icon" => ICON_VIEW,"title" => lang("App.View"),"href" =>$hrefView,"class" => "btn-primary ml-1",));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm","icon" => ICON_EDIT,"title" => lang("App.Edit"),"href" =>$hrefEdit,"class" => "btn-warning ml-1",));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm","icon" => ICON_DELETE,"title" => lang("App.Delete"),"href" =>$hrefDelete,"class" => "btn-danger ml-1",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnDelete));
        //[etc]---------------------------------------------------------------------------------------------------------
        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                array("content" => $row['location'], "class" => "text-left align-middle"),
                array("content" => $row['center'], "class" => "text-left align-middle"),
                array("content" => $row['shelve'], "class" => "text-left align-middle"),
                array("content" => $row['box'], "class" => "text-left align-middle"),
                array("content" => $row['folder'], "class" => "text-left align-middle"),
                array("content" => $row['author'], "class" => "text-left align-middle"),
                array("content" => $row['date'], "class" => "text-left align-middle"),
                //array("content" => $row['time'], "class" => "text-left align-middle"),
                //array("content" => $row['created_at'], "class" => "text-left align-middle"),
                //array("content" => $row['updated_at'], "class" => "text-left align-middle"),
                //array("content" => $row['deleted_at'], "class" => "text-left align-middle"),
                array("content" => $options, "class" => "text-center align-middle"),
            )
        );
    }
}
//[build]---------------------------------------------------------------------------------------------------------------
echo($bgrid);

?>