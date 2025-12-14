<?php
/** @var $oid * */
$bootstrap = service("bootstrap");
//[Models]--------------------------------------------------------------------------------------------------------------
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$mattachments = model("App\Modules\Sie\Models\Sie_Attachments");
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");
$mstatuses = model("App\Modules\Sie\Models\Sie_Statuses");
//[Request]-------------------------------------------------------------------------------------------------------------
$registration = $mregistrations->getRegistration($oid);

$photo = $mattachments->get_StudentPhoto($registration['registration']);

$actual_status = $mstatuses->where('registration', $oid)->orderBy('created_at', 'DESC')->first();


$image = "<img src=\"{$photo}\" class=\"w-100\" alt=\"\">";
$label = "Registrado";

// Eliminar el cambio de estado
$status = "<div class='status'>";
$status .= " <div class='status-title'>";
$status .= " <a id=\"link-status\"  class=\"text-white\" href=\"#\" data-bs-toggle=\"modal\" data-bs-target=\"#statusModal\">";
// Necesito sacar el valor textual del status
$statuses = LIST_STATUSES;
foreach ($statuses as $key => $value) {
    if (@$value['value'] == @$actual_status['reference']) {
        $label = $value['label'];
        //print_r($value);
        break;
    }
}
$status .= $label;
$status .= "</a></div>";
$status .= "</div>";

$card = $bootstrap->get_Card("profile-photo", array(
    "title" => sprintf(lang("Users.profile-photo") . "", $oid),
    "content" => $image,
));
echo($card);

$programs = $mprograms->get_SelectData();
include("Modals/change_status.php");
include("last_status.php");
include("Modals/wait.php");
include("Modals/javascript.php");
?>