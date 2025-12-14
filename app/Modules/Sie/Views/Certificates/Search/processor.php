<?php

//[services]------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[models]--------------------------------------------------------------------------------------------------------------
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
$mcertificates = model("App\Modules\Sie\Models\Sie_Certificates");
$mformats = model('App\Modules\Sie\Models\Sie_Formats');
//[vars]----------------------------------------------------------------------------------------------------------------
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
$f = service("forms", array("lang" => "Sie_Certificates."));

$d = array(
    "identification_type" => $f->get_Value("identification_type"),
    "identification_number" => $f->get_Value("identification_number"),
);
//[build]---------------------------------------------------------------------------------------------------------------
$registration = $mregistrations->getRegistrationByIdentification($d["identification_number"]);
$back = "/sie/certificates/search/" . lpk();
//print_r($registration);
if (isset($registration["registration"])) {
    $certificates = $mcertificates->where("registration", $registration["registration"])->find();
    if (is_array($certificates) && count($certificates) > 0) {
        foreach ($certificates as $certificate) {
            $format = $mformats->getFormat($certificate["format"]);
            $cCertificate = $certificate["certificate"];
            $cName = $format["name"];
            $cDescription = $format["description"];
            $cDate = $certificate["created_at"];
            $cType = $format["type"];
            $code = "<div class=\"card mb-3 border\">\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"card-body\">\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"row align-items-center\">\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"col-md-8\">\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<h5 class=\"card-title\">\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"fas fa-award text-warning me-2\"></i>\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t {$cName}\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</h5>\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<p class=\"card-text text-muted mb-2\">\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"fas fa-university me-2\"></i>\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t{$cDescription}\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</p>\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<p class=\"mb-2\">\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"badge bg-secondary\">\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t{$cType}\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</span>\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"ms-2 text-muted\">\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"fas fa-calendar-alt me-1\"></i>\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t{$cDate}\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</span>\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</p>\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<small class=\"text-muted\">\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"fas fa-barcode me-1\"></i>\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tCódigo: <strong>{$cCertificate}</strong>\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</small>\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"col-md-4 text-md-end mt-3 mt-md-0\">\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"d-grid gap-2\">\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<a class=\"btn btn-outline-primary\" href=\"/sie/certificates/view/{$cCertificate}\" target=\"_blank\">\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"fas fa-eye me-2\"></i>Visualizar\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</a>\n";
            //$code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<button class=\"btn btn-primary\" onclick=\"descargarDiploma('diploma_tecnico_software.pdf')\">\n";
            //$code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"fas fa-download me-2\"></i>Descargar\n";
            //$code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</button>\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t\t\t</div>\n";
            $code .= "\t\t\t\t\t\t\t\t\t\t</div>\n";
        }
        $c = $bootstrap->get_Card2('warning', array(
            'text-class' => 'text-center',
            'header-title' => lang("Sie_Certificates.search-success-title"),
            'header-back' => $back,
            'content' => $code,
            'footer-continue' => $back,
            'footer-class' => 'text-center',
        ));
    } else {
        $c = $bootstrap->get_Card2('warning', array(
            'text-class' => 'text-center',
            'header-title' => lang("Sie_Certificates.search-success-title"),
            'header-back' => $back,
            'content' => "No se encontraron certificados...",
            'footer-continue' => $back,
            'footer-class' => 'text-center',
        ));
    }

} else {
    $c = $bootstrap->get_Card('success', array(
        'class' => 'card-success',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'title' => lang("Sie_Certificates.search-noexist-title"),
        'text' => lang("Sie_Certificates.search-noexist-message"),
        'footer-class' => 'text-center',
        'footer-continue' => $back,
        'voice' => "sie/certificates-search-noexist-message.mp3",
    ));
}
echo($c);
?>