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


$row = $mrecommendations->find($oid);
$dimension = $mdimensions->find($row["dimension"]);
$politic = $mpolitics->find($row["politic"]);

$r["recommendation"] = $f->get_Value("recommendation", $row["recommendation"]);
$r["dimension"] = $row["dimension"] . ": " . urldecode($dimension["name"]);
$r["reference"] = $f->get_Value("reference", $row["reference"]);
$r["politic"] = $row["politic"] . ":" . urldecode($politic["name"]);
$r["component"] = $f->get_Value("component", $row["component"]);
$r["category"] = $f->get_Value("category", $row["category"]);
$r["activity"] = $f->get_Value("activity", $row["activity"]);
$r["description"] = urldecode($f->get_Value("description", $row["description"]));
$r["author"] = $f->get_Value("author", $authentication->get_User());
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
$dimensions = $mdimensions->get_SelectData();
$politics = $mpolitics->get_SelectData($dimensions[0]["value"]);

$cancel = "/disa/mipg/recommendations/list/" . $r["reference"] . "/" . lpk();
/*
* -----------------------------------------------------------------------------
* [Fields]
* -----------------------------------------------------------------------------
*/
$f->fields["recommendation"] = $f->get_FieldText("recommendation", array("value" => $r["recommendation"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["reference"] = $f->get_FieldText("reference", array("value" => $r["reference"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["dimension"] = $f->get_FieldSelect("dimension", array("value" => $r["dimension"], "data" => $dimensions, "proportion" => "col-xxl-6 col-xl-6 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["politic"] = $f->get_FieldSelect("politic", array("value" => $r["politic"], "data" => $politics, "proportion" => "col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
$f->fields["component"] = $f->get_FieldText("component", array("value" => $r["component"], "proportion" => "col-12"));
$f->fields["category"] = $f->get_FieldText("category", array("value" => $r["category"], "proportion" => "col-12"));
$f->fields["activity"] = $f->get_FieldText("activity", array("value" => $r["activity"], "proportion" => "col-12"));
$f->fields["description"] = $f->get_FieldTextArea("description", array("value" => $r["description"], "proportion" => "col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $cancel, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
/*
* -----------------------------------------------------------------------------
* [Groups]
* -----------------------------------------------------------------------------
*/
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["recommendation"] . $f->fields["reference"] . $f->fields["dimension"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["politic"])));
//$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["component"])));
//$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["category"])));
//$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["activity"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));
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
$smarty->assign("header", lang("Disa.recommendations-edit-title"));
$smarty->assign("body", $f);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));
?>
<script async>
    $(document).ready(function () {
        var fn_dimension = '#<?php echo($f->get_fid());?>_dimension';
        var fn_politic = '#<?php echo($f->get_fid());?>_politic';
        var field_dimensions = $(fn_dimension);
        var field_politics = $(fn_politic);

        document.querySelector(fn_dimension).addEventListener('change', function () {
            var dimension = getFieldValue("dimension");
            console.log(dimension);
            loadPolitics(dimension);

        });

        function loadPolitics(dimension) {
            $.ajax({
                data: {'dimension': dimension},
                url: '/disa/mipg/api/politics/json/list/' + Date.now(),
                type: 'POST',
                dataType: 'json',
                beforeSend: function () {
                    field_dimensions.prop('disabled', true);
                    field_politics.prop('disabled', true);
                },
                success: function (response) {
                    field_dimensions.prop('disabled', false);
                    field_politics.prop('disabled', false);
                    field_politics.find('option').remove();

                    $(response).each(function (i, v) {
                        if (v.value == "00") {
                            field_politics.append('<option value="00">Seleccione una dimensión</option>');
                        } else {
                            field_politics.append('<option value="' + v.value + '">' + v.label + '</option>');
                        }
                    })
                    //cursos.prop('disabled', false);
                },
                error: function () {
                    console.log('Ocurrió un error en el servidor ..');
                    //alumnos.prop('disabled', false);
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