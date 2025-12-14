<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-03-19 21:08:30
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Helpdesk\Views\Conversations\Creator\form.php]
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
 * █ @var object $parent Trasferido desde el controlador
 * █ @var object $authentication Trasferido desde el controlador
 * █ @var object $request Trasferido desde el controlador
 * █ @var object $dates Trasferido desde el controlador
 * █ @var string $component Trasferido desde el controlador
 * █ @var string $view Trasferido desde el controlador
 * █ @var string $oid Trasferido desde el controlador
 * █ @var string $views Trasferido desde el controlador
 * █ @var string $prefix Trasferido desde el controlador
 * █ @var array $data Trasferido desde el controlador
 * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Conversations."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Helpdesk\Models\Helpdesk_Conversations");
$mservices = model("App\Modules\Helpdesk\Models\Helpdesk_Services");
//[vars]----------------------------------------------------------------------------------------------------------------
$r["conversation"] = $f->get_Value("conversation", pk());
$r["service"] = $f->get_Value("service");
$r["title"] = $f->get_Value("title");
$r["description"] = $f->get_Value("description");
$r["status"] = $f->get_Value("status");
$r["priority"] = $f->get_Value("priority");
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
$r["document_type"] = $f->get_Value("document_type");
$r["document_number"] = $f->get_Value("document_number");
$r["first_name"] = $f->get_Value("first_name");
$r["last_name"] = $f->get_Value("last_name");
$r["email"] = $f->get_Value("email");
$r["phone"] = $f->get_Value("phone");
$r["agent"] = $f->get_Value("agent");
$r["type"] = $f->get_Value("type");
$r["category"] = $f->get_Value("category");
$r["attachment"] = $f->get_Value("attachment");
$back = "/helpdesk/home/index/" . lpk();
$document_types = array(
    array("label" => "Cédula de ciudadanía", "value" => "CC"),
    array("label" => "Cédula de extranjeria", "value" => "CE"),
    array("label" => "Pasaporte", "value" => "PA"),
    array("label" => "Tarjeta de identidad", "value" => "TI"),
    array("label" => "Registro civil", "value" => "RC"),
    array("label" => "NIT", "value" => "NIT"),
);
$services = $mservices->get_SelectData();
$agent = array();
$categories = array();
$types = array();

//[fields]----------------------------------------------------------------------------------------------------------------
$f->fields["conversation"] = $f->get_FieldText("conversation", array("value" => $r["conversation"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["service"] = $f->get_FieldSelect("service", array("selected" => $r["service"], "data" => $services, "proportion" => "col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12"));
$f->fields["agent"] = $f->get_FieldSelect("agent", array("selected" => $r["agent"], "data" => $agent, "proportion" => "col-12"));
$f->fields["title"] = $f->get_FieldText("title", array("value" => $r["title"], "proportion" => "col-12"));
$f->fields["description"] = $f->get_FieldTextArea("description", array("value" => $r["description"], "proportion" => "col-12"));
$f->fields["status"] = $f->get_FieldText("status", array("value" => $r["status"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["priority"] = $f->get_FieldText("priority", array("value" => $r["priority"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["type"] = $f->get_FieldSelect("type", array("selected" => $r["type"], "data" => $types, "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["category"] = $f->get_FieldSelect("category", array("selected" => $r["category"], "data" => $categories, "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["document_type"] = $f->get_FieldSelect("document_type", array("selected" => $r["document_type"], "data" => $document_types, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["document_number"] = $f->get_FieldText("document_number", array("value" => $r["document_number"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["first_name"] = $f->get_FieldText("first_name", array("value" => $r["first_name"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["last_name"] = $f->get_FieldText("last_name", array("value" => $r["last_name"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["email"] = $f->get_FieldText("email", array("value" => $r["email"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["phone"] = $f->get_FieldText("phone", array("value" => $r["phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["attachment"] = $f->get_FieldFile("attachment", array("value" => $r["attachment"], "proportion" => "col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["conversation"] . $f->fields["service"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["agent"]), "class" => "d-none", "id" => "group-agent"));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["type"] . $f->fields["category"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["document_type"] . $f->fields["document_number"] . $f->fields["first_name"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["last_name"] . $f->fields["email"] . $f->fields["phone"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["title"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["attachment"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("create", array(
    "title" => lang("Conversations.create-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>
<script>
    const serviceSelect = document.getElementById("<?php echo($f->get_fid());?>_service");
    const agentSelect = document.getElementById("<?php echo($f->get_fid());?>_agent");
    const typeSelect = document.getElementById("<?php echo($f->get_fid());?>_type");
    const categorySelect = document.getElementById("<?php echo($f->get_fid());?>_category");
    const groupagentDiv = document.getElementById("group-agent");

    changeType();
    changeService();

    typeSelect.addEventListener("change", function () {
        changeType();
    });

    serviceSelect.addEventListener("change", function () {
        changeService();
    });

    function changeType() {
        categorySelect.innerHTML = "";
        let selectedType = typeSelect.value;
        if (selectedType == "") {
            selectedType = "null";
        }

        console.log("selectedType:" + selectedType);
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "/helpdesk/api/categories/json/select/" + selectedType, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response) {
                    categories = response.categories;
                    if (categories.length > 0) {
                        categorySelect.innerHTML = "";
                        categories.forEach(category => {
                            const option = document.createElement("option");
                            option.value = category.value;
                            option.textContent = category.label;
                            categorySelect.appendChild(option);
                        });
                    } else {
                        console.log("No hay categorias disponibles para este tipo.");
                    }
                } else {
                    console.log("No hay datos disponibles para este tipo.");
                }
            } else {
                console.error("Error en la solicitud XHR.");
            }
        };
        xhr.send();
    }

    function changeService() {
        var selectedService = serviceSelect.value;
        console.log("serviceSelect:" + serviceSelect);
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "/helpdesk/api/services/json/agents/" + selectedService, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response) {
                    direct = response.direct;
                    count = response.count;
                    agents = response.agents;
                    types = response.types;
                    if (direct == 'Y') {
                        groupagentDiv.classList.remove("d-none");
                        if (count > 0) {
                            agentSelect.innerHTML = "";
                            agents.forEach(agent => {
                                const option = document.createElement("option");
                                option.value = agent.value;
                                option.textContent = agent.label;
                                agentSelect.appendChild(option);
                            });
                        } else {
                            groupagentDiv.classList.add("d-none");
                        }
                    } else {
                        groupagentDiv.classList.add("d-none");
                    }
                    typeSelect.innerHTML = "";
                    types.forEach(type => {
                        const option = document.createElement("option");
                        option.value = type.value;
                        option.textContent = type.label;
                        typeSelect.appendChild(option);
                    });
                    changeType();
                } else {
                    groupagentDiv.classList.add("d-none");
                    console.log("No hay datos disponibles para este servicio.");
                }
            } else {
                console.error("Error en la solicitud XHR.");
            }
        };
        xhr.send();
    }
</script>
