<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-10-09 06:43:36
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Helpdesk\Views\Agents\Creator\form.php]
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
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
$bootstrap = service("bootstrap");
$f = service("forms", array("lang" => "Agents."));
$mservices = model("App\Modules\Helpdesk\Models\Helpdesk_Services");
$musers = model("App\Modules\Helpdesk\Models\Helpdesk_Users");
$mfields = model("App\Modules\Helpdesk\Models\Helpdesk_Users_Fields");

$service = $mservices->where("service", $oid)->first();

//[Requests]------------------------------------------------------------------------------------------------------------
$r["agent"] = $f->get_Value("agent", pk());
$r["service"] = $f->get_Value("service", $oid);
$r["service_name"] = safe_urldecode($service["name"]);
$r["user"] = $f->get_Value("user");
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$r["users"] = $f->get_Value("users");
$back = "/helpdesk/services/view/" . $oid;
$users = $musers->findAll();

$rusers = array();
foreach ($users as $user) {
    $ruser = array();
    $profile = $mfields->get_Profile($user['user']);
    $name = $profile['name'];
    $ruser['label'] = $name;
    $ruser['value'] = $user['user'];
    array_push($rusers, $ruser);
}

function compararPorLabel($a, $b)
{
    return strcmp($a["label"], $b["label"]);
}

// Ordenar el arreglo en función de los "labels"
usort($rusers, 'compararPorLabel');

//[Fields]--------------------------------------------------------------------------------------------------------------
$f->fields["agent"] = $f->get_FieldText("agent", array("value" => $r["agent"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["service"] = $f->get_FieldText("service", array("value" => $r["service"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["service_name"] = $f->get_FieldText("service_name", array("value" => $r["service_name"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["user"] = $f->get_FieldText("user", array("value" => $r["user"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["users"] = $f->get_FieldSelect("users", array("selected" => $r["users"], "data" => $rusers, "proportion" => "col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[Groups]--------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["agent"] . $f->fields["service"] . $f->fields["service_name"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["user"] . $f->fields["users"])));
//[Buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
    "title" => lang("Agents.create-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>
<script>
    const users = document.getElementById("<?php echo($f->get_fid());?>_users");
    const user = document.getElementById("<?php echo($f->get_fid());?>_user");
    users.addEventListener("change", function () {
        user.value = users.value;
    });
</script>