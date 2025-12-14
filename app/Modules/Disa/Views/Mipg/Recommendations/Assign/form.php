<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Recommendations\Editor\form.php]
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
$f = service("forms", array("lang" => "Disa.recommendations-"));
/*
* -----------------------------------------------------------------------------
* [Requests]
* -----------------------------------------------------------------------------
*/
$mrecommendations = model("App\Modules\Disa\Models\Disa_Recommendations");
$mdimensions = model("App\Modules\Disa\Models\Disa_Dimensions");
$mpolitics = model("App\Modules\Disa\Models\Disa_Politics");
$mdiagnostics = model("App\Modules\Disa\Models\Disa_Diagnostics");
$mcomponents = model("\App\Modules\Disa\Models\Disa_Components");
$mcategories = model("App\Modules\Disa\Models\Disa_Categories");
$mactivities = model("\App\Modules\Disa\Models\Disa_Activities");


$row = $mrecommendations->find($oid);
$dimension = $mdimensions->find($row["dimension"]);
$politic = $mpolitics->find($row["politic"]);
$diagnostic = $mdiagnostics->find($row["diagnostic"]);
$activity = $mactivities->find($row["activity"]);

$r["recommendation"] = $f->get_Value("recommendation", $row["recommendation"]);
$r["reference"] = $f->get_Value("reference", $row["reference"]);
$r["dimension"] = $f->get_Value("dimension", $row["dimension"]);
$r["politic"] = $f->get_Value("politic", $row["politic"]);
$r["diagnostic"] = $f->get_Value("diagnostic", $row["diagnostic"]);
$r["component"] = $f->get_Value("component", $row["component"]);
$r["category"] = $f->get_Value("category", $row["category"]);
$r["activity"] = $f->get_Value("activity", $row["activity"]);
$r["description"] = urldecode($f->get_Value("description", $row["description"]));
$r["author"] = $f->get_Value("author", $authentication->get_User());
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);

$dimensions = $mdimensions->get_SelectData();
$politics = $mpolitics->get_SelectData($r["dimension"]);
$diagnostics = $mdiagnostics->get_SelectData($row["politic"]);
$components = $mcomponents->get_SelectData($row["diagnostic"]);
$categories = $mcategories->get_SelectData($row["component"]);
$activities = $mactivities->get_SelectData($row["activity"]);

$cancel = "/disa/mipg/recommendations/home/" . $r["reference"] . "/" . lpk();
/*
* -----------------------------------------------------------------------------
* [Fields]
* -----------------------------------------------------------------------------
*/
$f->fields["recommendation"] = $f->get_FieldText("recommendation", array("value" => $r["recommendation"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["reference"] = $f->get_FieldText("reference", array("value" => $r["reference"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["dimension"] = $f->get_FieldSelect("dimension", array("value" => $r["dimension"], "data" => $dimensions, "proportion" => "col-xxl-6 col-xl-6 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["politic"] = $f->get_FieldSelect("politic", array("value" => $r["politic"], "data" => $politics, "proportion" => "col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
$f->fields["diagnostic"] = $f->get_FieldSelect("diagnostic", array("value" => $r["diagnostic"], "data" => $diagnostics, "proportion" => "col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
$f->fields["component"] = $f->get_FieldSelect("component", array("value" => $r["component"], "data" => $components, "proportion" => "col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
$f->fields["category"] = $f->get_FieldSelect("category", array("value" => $r["category"], "data" => $categories, "proportion" => "col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
$f->fields["activity"] = $f->get_FieldSelect("activity", array("value" => $r["activity"], "data" => $activities, "proportion" => "col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
$f->fields["description"] = $f->get_FieldTextArea("description", array("value" => $r["description"], "proportion" => "col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $cancel, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Assign"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
/*
* -----------------------------------------------------------------------------
* [Groups]
* -----------------------------------------------------------------------------
*/
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["recommendation"] . $f->fields["reference"] . $f->fields["dimension"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["politic"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["diagnostic"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["component"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["category"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["activity"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));
//$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["updated_at"] . $f->fields["deleted_at"])));
/*
* -----------------------------------------------------------------------------
* [Buttons]
* -----------------------------------------------------------------------------
*/
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "normal");
$smarty->assign("header", lang("Disa.recommendations-assign-priority-title"));
$smarty->assign("body", $f);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));
?>
<script async>
    $(document).ready(function () {
        var fn_dimension = '#<?php echo($f->get_fid());?>_dimension';
        var fn_politic = '#<?php echo($f->get_fid());?>_politic';
        var fn_diagnostic = '#<?php echo($f->get_fid());?>_diagnostic';
        var fn_component = '#<?php echo($f->get_fid());?>_component';
        var fn_category = '#<?php echo($f->get_fid());?>_category';
        var fn_activity = '#<?php echo($f->get_fid());?>_activity';

        var field_dimensions = $(fn_dimension);
        var field_politics = $(fn_politic);
        var field_diagnostics = $(fn_diagnostic);
        var field_components = $(fn_component);
        var field_categories = $(fn_category);
        var field_activities = $(fn_activity);

        var dimension = getFieldValue("dimension");
        var politic = getFieldValue("politic");
        var diagnostic = getFieldValue("diagnostic");
        var component = getFieldValue("component");
        var category = getFieldValue("category");
        var activity = getFieldValue("activity");

        document.querySelector(fn_dimension).addEventListener('change', function () {
            var dimension = getFieldValue("dimension");
            //console.log(dimension);
            loadPolitics(dimension);
        });

        document.querySelector(fn_politic).addEventListener('change', function () {
            var politic = getFieldValue("politic");
            loadDiagnostics(politic);

        });

        document.querySelector(fn_diagnostic).addEventListener('change', function () {
            var diagnostic = getFieldValue("diagnostic");
            loadComponents(diagnostic);
        });

        document.querySelector(fn_component).addEventListener('change', function () {
            var component = getFieldValue("component");
            loadCategories(component);
        });

        document.querySelector(fn_category).addEventListener('change', function () {
            var category = getFieldValue("category");
            loadActivities(category);
        });


        locker();
        field_dimensions.prop('disabled', false);
        field_politics.prop('disabled', false);

        if (politic != "") {
            field_politics.prop('disabled', false);
            if (diagnostic == "") {
                loadDiagnostics(politic);
            }
            //console.log("Diagnostic: "+ diagnostic);
        }
        if (diagnostic != "") {
            field_diagnostics.prop('disabled', false);
        }
        if (component != "") {
            field_components.prop('disabled', false);
        }
        if (category != "") {
            field_categories.prop('disabled', false);
        }
        if (activity != "") {
            field_activities.prop('disabled', false);
        }

        function locker() {
            field_dimensions.prop('disabled', true);
            field_politics.prop('disabled', true);
            field_diagnostics.prop('disabled', true);
            field_components.prop('disabled', true);
            field_categories.prop('disabled', true);
            field_activities.prop('disabled', true);
        }

        function loadPolitics(dimension) {
            $.ajax({
                data: {'dimension': dimension},
                url: '/disa/mipg/api/politics/json/list/' + Date.now(),
                type: 'POST',
                dataType: 'json',
                beforeSend: function () {
                    locker();
                },
                success: function (response) {
                    /* Unlock Fields */
                    field_dimensions.prop('disabled', false);
                    field_politics.prop('disabled', false);
                    field_diagnostics.prop('disabled', true);
                    field_components.prop('disabled', true);
                    field_categories.prop('disabled', true);
                    field_activities.prop('disabled', true);
                    /* Remove datas */
                    field_politics.find('option').remove();
                    field_diagnostics.find('option').remove();
                    field_components.find('option').remove();
                    field_categories.find('option').remove();
                    field_activities.find('option').remove();
                    /* Load datas */
                    field_politics.append('<option value="">- Seleccione una política -</option>');
                    $(response).each(function (i, v) {
                        field_politics.append('<option value="' + v.value + '">' + v.label + '</option>');
                    })
                },
                error: function () {
                    console.log('Ocurrió un error en el servidor ..');
                }
            });
        }


        function loadDiagnostics(politic) {
            $.ajax({
                data: {'politic': politic},
                url: '/disa/mipg/api/diagnostics/json/list/' + Date.now(),
                type: 'POST',
                dataType: 'json',
                beforeSend: function () {
                    locker();
                },
                success: function (response) {
                    /* Unlock Fields */
                    field_dimensions.prop('disabled', false);
                    field_politics.prop('disabled', false);
                    field_diagnostics.prop('disabled', false);
                    field_components.prop('disabled', true);
                    field_categories.prop('disabled', true);
                    field_activities.prop('disabled', true);
                    /* Remove datas */
                    field_diagnostics.find('option').remove();
                    field_components.find('option').remove();
                    field_categories.find('option').remove();
                    field_activities.find('option').remove();
                    /* Load datas */
                    field_diagnostics.append('<option value="">- Seleccione un diagnostico -</option>');
                    $(response).each(function (i, v) {
                        field_diagnostics.append('<option value="' + v.value + '">' + v.label + '</option>');
                    })
                },
                error: function () {
                    console.log('Ocurrió un error en el servidor ..');
                }
            });
        }


        function loadComponents(diagnostic) {
            $.ajax({
                data: {'diagnostic': diagnostic},
                url: '/disa/mipg/api/components/json/list/' + Date.now(),
                type: 'POST',
                dataType: 'json',
                beforeSend: function () {
                    locker();
                },
                success: function (response) {
                    /* Unlock Fields */
                    field_dimensions.prop('disabled', false);
                    field_politics.prop('disabled', false);
                    field_diagnostics.prop('disabled', false);
                    field_components.prop('disabled', false);
                    field_categories.prop('disabled', true);
                    field_activities.prop('disabled', true);
                    /* Remove datas */
                    field_components.find('option').remove();
                    field_categories.find('option').remove();
                    field_activities.find('option').remove();
                    /* Load datas */
                    field_components.append('<option value="">- Seleccione un componente -</option>');
                    $(response).each(function (i, v) {
                        field_components.append('<option value="' + v.value + '">' + v.label + '</option>');
                    })
                },
                error: function () {
                    console.log('Ocurrió un error en el servidor ..');
                }
            });
        }


        function loadCategories(component) {
            $.ajax({
                data: {'component': component},
                url: '/disa/mipg/api/categories/json/list/' + Date.now(),
                type: 'POST',
                dataType: 'json',
                beforeSend: function () {
                    locker();
                },
                success: function (response) {
                    /* Unlock Fields */
                    field_dimensions.prop('disabled', false);
                    field_politics.prop('disabled', false);
                    field_diagnostics.prop('disabled', false);
                    field_components.prop('disabled', false);
                    field_categories.prop('disabled', false);
                    field_activities.prop('disabled', true);
                    /* Remove datas */
                    field_categories.find('option').remove();
                    field_activities.find('option').remove();
                    /* Load datas */
                    field_categories.append('<option value="">- Seleccione una categoría -</option>');
                    $(response).each(function (i, v) {
                        field_categories.append('<option value="' + v.value + '">' + v.label + '</option>');
                    })
                },
                error: function () {
                    console.log('Ocurrió un error en el servidor ..');
                }
            });
        }

        function loadActivities(category) {
            $.ajax({
                data: {'category': category},
                url: '/disa/mipg/api/activities/json/list/' + Date.now(),
                type: 'POST',
                dataType: 'json',
                beforeSend: function () {
                    locker();
                },
                success: function (response) {
                    /* Unlock Fields */
                    field_dimensions.prop('disabled', false);
                    field_politics.prop('disabled', false);
                    field_diagnostics.prop('disabled', false);
                    field_components.prop('disabled', false);
                    field_categories.prop('disabled', false);
                    field_activities.prop('disabled', false);
                    /* Remove datas */
                    field_activities.find('option').remove();
                    /* Load datas */
                    field_activities.append('<option value="">- Seleccione una actividad -</option>');
                    $(response).each(function (i, v) {
                        field_activities.append('<option value="' + v.value + '">' + v.label + '</option>');
                    })
                },
                error: function () {
                    console.log('Ocurrió un error en el servidor ..');
                }
            });
        }


        function getFieldValue(name) {
            var namefield = "<?php echo($f->get_fid());?>_" + name;
            var value = null;
            if (!!document.getElementById(namefield)) {
                var element = document.getElementById(namefield);
                value = element.value;
                console.log(namefield + "=" + value);
            }
            return (value);
        }

    });
</script>