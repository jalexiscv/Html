<?php
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');

$mattachments = model('App\Modules\Cadastre\Models\Cadastre_Attachments');
$mcp = model("App\Modules\Cadastre\Models\Cadastre_Profiles");

$profile = $mcp->where('customer', $oid)->orderBy('created_at', 'DESC')->first();
$attachments = $mattachments->where('object', $profile['profile'])->findAll();

$code = "";
foreach ($attachments as $attachment) {
    $code .= '<div class="card">';
    $code .= '<div class="card-body">';
    $code .= '<div class="row">';
    $code .= '<div class="col-12">';
    $code .= '<div class="text-center">';
    $code .= '<a href="' . base_url() . '' . $attachment['file'] . '" target="_blank">';
    $code .= '<img src="' . base_url() . '' . $attachment['file'] . '" class="img-fluid" alt="' . $attachment['attachment'] . '">';
    $code .= '</a>';
    $code .= '</div>';
    $code .= '</div>';
    $code .= '<div class="col-12">';
    $code .= '<div class="text-center">';
    $code .= '<a href="' . base_url() . '' . $attachment['file'] . '" target="_blank">';
    $code .= '<i class="fa-solid fa-paperclip fa-2xl"></i>';
    $code .= '</a>';
    $code .= '</div>';
    $code .= '</div>';
    $code .= '</div>';
    $code .= '</div>';
    $code .= '</div>';
}

$card = $bootstrap->get_Card("card-view-service", array(
    "title" => "Archivos Adjuntos",
    "header-back" => false,
    "content" => $code,
));
echo($card);
?>