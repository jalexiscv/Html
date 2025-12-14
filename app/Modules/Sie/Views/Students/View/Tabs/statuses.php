<?php
//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service('bootstrap');
//[vars]----------------------------------------------------------------------------------------------------------------
$mstatuses = model('App\Modules\Sie\Models\Sie_Statuses');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
$mgrids = model('App\Modules\Sie\Models\Sie_Grids');
$mversions = model('App\Modules\Sie\Models\Sie_Versions');
$mpensums = model('App\Modules\Sie\Models\Sie_Pensums');
$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');
//[grid]----------------------------------------------------------------------------------------------------------------
$offset = !empty($request->getVar("offset")) ? $request->getVar("offset") : 0;
$search = !empty($request->getVar("search")) ? $request->getVar("search") : "";
$field = !empty($request->getVar("field")) ? $request->getVar("field") : "";
$limit = !empty($request->getVar("limit")) ? $request->getVar("limit") : 10;
$fields = array(
    //"status" => lang("App.status"),
    //"registration" => lang("App.registration"),
    //"program" => lang("App.program"),
    //"cycle" => lang("App.cycle"),
    //"reference" => lang("App.reference"),
    //"date" => lang("App.date"),
    //"time" => lang("App.time"),
    //"author" => lang("App.author"),
    //"locked_at" => lang("App.locked_at"),
    //"created_at" => lang("App.created_at"),
    //"updated_at" => lang("App.updated_at"),
    //"deleted_at" => lang("App.deleted_at"),
);
//[build]--------------------------------------------------------------------------------------------------------------
$conditions = array(
    "registration" => $oid,
);
//$mstatuses->clear_AllCache();
$rows = $mstatuses->getSearchByRegistration($conditions, $limit, $offset);
$total = $mstatuses->get_CountAllResults($conditions);
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
    //array("content" => lang("App.Status"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.registration"), "class" => "text-center	align-middle"),
    array("content" => "Historial de estados", "class" => "text-center	align-middle"),
    //array("content" => lang("App.Cycle"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.reference"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Date"), "class" => "text-center	align-middle"),
    array("content" => "Fecha Matricula", "class" => "text-center	align-middle"),
    array("content" => "Créditos Matriculables", "class" => "text-center	align-middle"),
    //array("content" => lang("App.author"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.locked_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.created_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.updated_at"), "class" => "text-center	align-middle"),
    //array("content" => lang("App.deleted_at"), "class" => "text-center	align-middle"),
    array("content" => lang("App.Options"), "class" => "text-center	align-middle"),
));
$bgrid->set_Search(array("search" => $search, "field" => $field, "fields" => $fields,));
$component = '/sie/statuses';
$count = $offset;
foreach ($rows["data"] as $row) {
    if (!empty($row["status"])) {
        $count++;
        //[links]-------------------------------------------------------------------------------------------------------
        $hrefView = "$component/view/{$row["status"]}";
        $hrefEdit = "$component/edit/{$row["status"]}";
        $hrefDelete = "$component/delete/{$row["status"]}";
        //[buttons]-----------------------------------------------------------------------------------------------------
        $btnView = $bootstrap->get_Link("btn-view", array("size" => "sm", "icon" => ICON_VIEW, "title" => lang("App.View"), "href" => $hrefView, "class" => "btn-sm btn-primary ml-1",));
        $btnEdit = $bootstrap->get_Link("btn-edit", array("size" => "sm", "icon" => ICON_EDIT, "title" => lang("App.Edit"), "href" => $hrefEdit, "class" => "btn-sm btn-warning ml-1",));
        $btnDelete = $bootstrap->get_Link("btn-delete", array("size" => "sm", "icon" => ICON_DELETE, "title" => lang("App.Delete"), "href" => $hrefDelete, "class" => "btn-sm btn-danger ml-1",));
        $options = $bootstrap->get_BtnGroup("btn-group", array("content" => $btnDelete . $btnEdit));
        //[etc]---------------------------------------------------------------------------------------------------------
        $program_name = "";
        $program = $mprograms->getProgram($row["program"]);
        $grid = $mgrids->get_Grid($row["grid"]);
        $version = $mversions->get_Version($row["version"]);

        if (is_array($program)) {
            $program_name = @$program["name"];
        }


        $period = @$row['period'];
        $reference = @$row['reference'];
        $reference_name = "";
        foreach (LIST_STATUSES as $status) {
            if ($status['value'] == $reference) {
                $reference_name = $status['label'];
                break;
            }
        }

        $responsible = $mfields->get_Profile($row['author']);
        $responsible_name = @$responsible['name'];

        $observation = @$row['observation'];
        $moment = @$row['moment'];
        $cycle = @$row['cycle'];
        $journey = @$row['journey'];

        $grid_grid = @$grid["grid"];
        $grid_name = @$grid['name'];
        $version_version = @$version["version"];
        $version_reference = @$version['reference'];

        $details = "";
        $details .= "<strong>" . lang("App.Program") . ":</strong> $program_name <span class=\"opacity-25\">{$row["program"]}</span><br>";
        if (!empty($grid_name)) {
            $details .= "<strong>Malla:</strong> $grid_name <span class=\"opacity-25\">$grid_grid</span><br>";
        }
        if (!empty($version_reference)) {
            $details .= "<strong>Versión:</strong>$version_reference <span class=\"opacity-25\">$version_version</span><br>";
        }

        $details .= "<strong>" . lang("App.Status") . ":</strong>  $reference_name | <strong>" . lang("App.Period") . ":</strong> $period | ";

        if (@$row['reference'] == "GRADUATED") {
            $degree_certificate = @$row['degree_certificate'];
            $degree_folio = @$row['degree_folio'];
            $degree_date = @$row['degree_date'];
            $degree_diploma = @$row['degree_diploma'];
            $degree_book = @$row['degree_book'];
            $degree_resolution = @$row['degree_resolution'];
            $details .= "<b>Acta de grado</b>: {$degree_certificate} | <b>Número de folio</b>: {$degree_folio} | <b>Fecha de grado</b>: {$degree_date} | ";
            $details .= "<b>Diploma</b>: {$degree_diploma} | <b>Libro</b>: {$degree_book} | <b>Resolución</b>: {$degree_resolution} <br>";
        }

        $details .= "<strong>Jornada</strong>: {$journey} | ";

        $details .= "<strong>Momento:</strong> $moment  | <strong>Ciclo:</strong> $cycle <br> ";
        $details .= "<strong> Responsable</strong>: $responsible_name <br>";
        $details .= "<strong> Observación:</strong> $observation";

        $credits = $mpensums->get_CalculateCredits($row["program"], $row["grid"], $row["version"], $cycle);

        if (empty($cycle) || empty($moment)) {
            $credits = "21";
        }

        $bgrid->add_Row(
            array(
                array("content" => $count, "class" => "text-center align-middle"),
                //array("content" => $row['status'], "class" => "text-left align-middle"),
                //array("content" => $row['registration'], "class" => "text-left align-middle"),
                array("content" => $details, "class" => "text-left align-middle"),
                //array("content" => $row['cycle'], "class" => "text-left align-middle"),
                //array("content" => $row['reference'], "class" => "text-left align-middle"),
                array("content" => $row['date'] . "<br>" . $row['time'], "class" => "text-center align-middle"),
                array("content" => $row['enrollment_date'], "class" => "text-center align-middle"),
                array("content" => $credits, "class" => "text-center align-middle"),
                //array("content" => $row['author'], "class" => "text-left align-middle"),
                //array("content" => $row['locked_at'], "class" => "text-left align-middle"),
                //array("content" => $row['created_at'], "class" => "text-left align-middle"),
                //array("content" => $row['updated_at'], "class" => "text-left align-middle"),
                //array("content" => $row['deleted_at'], "class" => "text-left align-middle"),
                array("content" => $options, "class" => "text-center align-middle"),
            )
        );
    }
}


$addstatus = "";
$addstatus .= "<div class=\"row\">\n";
$addstatus .= "    <div class=\"col-6\">\n";
$addstatus .= "        <div class=\"input-group mb-3\">\n";
$addstatus .= "            <a id=\"btn-bill\" class=\"btn btn-secondary\" href=\"#\" data-bs-toggle=\"modal\" data-bs-target=\"#statusModal\"><i class=\"icon fa-light fa-plus \"></i><div class=\"btn-text-inline\">Crear Estado</div></a>\n";
$addstatus .= "        </div>\n";
$addstatus .= "    </div>\n";
$addstatus .= "</div>\n";








//[build]---------------------------------------------------------------------------------------------------------------
$create_status = "/sie/statuses/create/{$oid}";
$info = $bootstrap->get_Alert(array(
    'type' => 'info',
    'title' => lang('App.Remember'),
    "message" => sprintf(lang("Sie_Statuses.message-statuses-student-list-info"), $create_status),
));
echo($info);
echo($addstatus);
echo($bgrid);
?>