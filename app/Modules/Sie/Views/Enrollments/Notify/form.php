<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-05-01 08:14:09
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Registrations\Editor\form.php]
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
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Sie_Registrations."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sie\Models\Sie_Registrations");
//[vars]----------------------------------------------------------------------------------------------------------------
$row = $model->getRegistration($oid);
$r["registration"] = $f->get_Value("registration", $row["registration"]);
$r["first_name"] = $f->get_Value("first_name", $row["first_name"]);
$r["second_name"] = $f->get_Value("second_name", $row["second_name"]);
$r["first_surname"] = $f->get_Value("first_surname", $row["first_surname"]);
$r["second_surname"] = $f->get_Value("second_surname", $row["second_surname"]);
$r["identification_type"] = $f->get_Value("identification_type", $row["identification_type"]);
$r["identification_number"] = $f->get_Value("identification_number", $row["identification_number"]);
$r["gender"] = $f->get_Value("gender", $row["gender"]);
$r["email_address"] = $f->get_Value("email_address", $row["email_address"]);
$r["phone"] = $f->get_Value("phone", $row["phone"]);
$r["mobile"] = $f->get_Value("mobile", $row["mobile"]);
$r["birth_date"] = $f->get_Value("birth_date", $row["birth_date"]);
$r["address"] = $f->get_Value("address", $row["address"]);
$r["residence_city"] = $f->get_Value("residence_city", $row["residence_city"]);
$r["neighborhood"] = $f->get_Value("neighborhood", $row["neighborhood"]);
$r["area"] = $f->get_Value("area", $row["area"]);
$r["stratum"] = $f->get_Value("stratum", $row["stratum"]);
$r["transport_method"] = $f->get_Value("transport_method", $row["transport_method"]);
$r["sisben_group"] = $f->get_Value("sisben_group", $row["sisben_group"]);
$r["sisben_subgroup"] = $f->get_Value("sisben_subgroup", $row["sisben_subgroup"]);
$r["document_issue_place"] = $f->get_Value("document_issue_place", $row["document_issue_place"]);
$r["birth_city"] = $f->get_Value("birth_city", $row["birth_city"]);
$r["blood_type"] = $f->get_Value("blood_type", $row["blood_type"]);
$r["marital_status"] = $f->get_Value("marital_status", $row["marital_status"]);
$r["number_children"] = $f->get_Value("number_children", $row["number_children"]);
$r["military_card"] = $f->get_Value("military_card", $row["military_card"]);
$r["ars"] = $f->get_Value("ars", $row["ars"]);
$r["insurer"] = $f->get_Value("insurer", $row["insurer"]);
$r["eps"] = $f->get_Value("eps", $row["eps"]);
$r["education_level"] = $f->get_Value("education_level", $row["education_level"]);
$r["occupation"] = $f->get_Value("occupation", $row["occupation"]);
$r["health_regime"] = $f->get_Value("health_regime", $row["health_regime"]);
$r["document_issue_date"] = $f->get_Value("document_issue_date", $row["document_issue_date"]);
$r["saber11"] = $f->get_Value("saber11", $row["saber11"]);
$back = "/sie/registrations/list/" . lpk();
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("registration", $r["registration"]);
$f->fields["to"] = $f->get_FieldText("to", array("value" => $r["email_address"], "proportion" => "col-12"));
$f->fields["subject"] = $f->get_FieldText("subject", array("value" => "¡Bienvenido a Utedé! Tu orden de pago para la matrícula está aquí.", "proportion" => "col-12", "readonly" => true));

//$code = "<p style=\"font-size: 1.3rem;font-weight: bold;\"'>¡Gracias por tu interés en unirte a nuestra comunidad!\n</p>";
//$code = "<p><font size=\"4\">¡Hola {$r["first_name"]}!</font></p>\n";

$code = "";

$code .= "<p>¡Estimado Utedista!</p>\n";

$code .= "<p>Es un placer darte la bienvenida oficialmente a nuestra comunidad universitaria. Estamos muy contentos de tenerte con nosotros y seguros de que tu tiempo en Utedé será una etapa llena de aprendizajes, crecimiento y nuevas experiencias.</p>\n";

$code .= "<p>Adjunto a este correo encontrarás tu orden de pago para la matrícula. Por favor, asegúrate de realizar el pago para garantizar tu cupo y comenzar esta emocionante etapa académica sin contratiempos.</p>\n";

$code .= "<p>En caso de que necesites alguna asistencia adicional o tengas preguntas sobre el proceso de pago, no dudes en ponerte en contacto con nosotros. Estamos aquí para ayudarte en cada paso de tu camino universitario.</p>\n";

$code .= "<p>Una vez más, ¡te damos la bienvenida a Utedé! Queremos verte crecer y triunfar en nuestra institución.</p>\n";

$code .= "<p style=\"font-size: 1.5rem;font-weight: normal;\">Adjunto Orden de Pago para Matrícula!: <a href=\"https://intranet.utede.edu.co/sie/enrollments/billing/{$oid}\">Orden de Pago para Matrícula!</a></p>\n";

$code .= "<p>Atentamente,</p>\n";

$code .= "<p>Matrícula Financiera</p>\n";
$code .= "<p><b>UNIDAD TÉCNICA PARA EL DESARROLLO PROFESIONAL, UTEDÉ</b></p>\n";
$code .= "<p>matriculafinanciera@utede.edu.co</p>\n";


$code .= "\n";

$f->fields["message"] = $f->get_FieldCKEditor("message", array("value" => $code, "proportion" => "col-12"));

$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Send"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["to"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["subject"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["message"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
    "title" => "Enviar recibo de matricula",
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>
