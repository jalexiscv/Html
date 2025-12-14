<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Intrusions\Creator\form.php]
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
* ----------------------------------------------------------------------------------------------------------------------
*/
$mmails = model("App\Modules\C4isr\Models\C4isr_Mails", false);
$count = $mmails->findAll();

$f = service("forms", array("lang" => "Intrusions."));
//[Requests]------------------------------------------------------------------------------------------------------------
$r["intrusion"] = $f->get_Value("intrusion", pk());
$r["vulnerability"] = $f->get_Value("vulnerability", pk());
$r["breach"] = $f->get_Value("breach", $oid);
$r["author"] = $f->get_Value("author", $authentication->get_User());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$r["prefix"] = $f->get_Value("prefix", "/imports/test");
$r["password"] = $f->get_Value("password");
$back = "/c4isr/intrusions/list/" . $oid;
//[Fields]--------------------------------------------------------------------------------------------------------------
$f->fields["intrusion"] = $f->get_FieldText("intrusion", array("value" => $r["intrusion"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["vulnerability"] = $f->get_FieldText("vulnerability", array("value" => $r["vulnerability"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["breach"] = $f->get_FieldText("breach", array("value" => $r["breach"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));

$f->fields["prefix"] = $f->get_FieldText("prefix", array("value" => $r["prefix"], "proportion" => "col-12"));

$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["xhr"] = $f->get_Button("xhr", array("text" => lang("App.Import"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Import"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[Groups]--------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["intrusion"] . $f->fields["breach"] . $f->fields["vulnerability"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["prefix"])));
//[Buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["xhr"] . $f->fields["cancel"]));
//[Build]---------------------------------------------------------------------------------------------------------------
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "normal");
$smarty->assign("header", lang("Intrusions.create-title"));
$smarty->assign("header_back", $back);
$smarty->assign("body", $f);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));
///c4isr/api/intrusions/json/import/intrusion
?>
<div id="transferLog" class="w-100">

</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("<?php echo($f->get_fid());?>_xhr").addEventListener("click", function (event) {

            function sendRequest() {
                var form = document.getElementById("<?php echo($f->get_fid());?>");
                var data = new FormData(form);
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "/c4isr/api/intrusions/json/import/<?php echo($oid);?>?t=" + Date.now(), true);
                xhr.onload = function () {
                    var transferLog = document.getElementById("transferLog");
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.status === "success") {
                            transferLog.innerHTML += "Status: " + response.status + "<br>Message: " + response.message;
                        } else {
                            transferLog.innerHTML += "Status: " + response.status + "<br>Message: " + response.message;
                        }
                        sendRequest();
                    } else {
                        transferLog.innerHTML += "Error: " + xhr.status;
                    }
                };
                xhr.send(data);
            }

            sendRequest();
        });
    });
</script>
