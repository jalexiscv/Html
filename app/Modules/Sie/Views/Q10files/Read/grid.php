<?php
require_once(APPPATH . 'ThirdParty/DocumentAI/autoload.php');

use Google\Cloud\DocumentAI\V1\Client\DocumentProcessorServiceClient;
use Google\Cloud\DocumentAI\V1\ProcessRequest;
use Google\Cloud\DocumentAI\V1\RawDocument;

//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/sie/tools/home/" . lpk();
//[models]--------------------------------------------------------------------------------------------------------------
$mq10files = model("App\Modules\Sie\Models\Sie_Q10files");
$mattachments = model('App\Modules\Storage\Models\Storage_Attachments', true);
//[request]-------------------------------------------------------------------------------------------------------------
$content = "";
//[build]---------------------------------------------------------------------------------------------------------------
$files = $mq10files->get_FilesAndAttachments(10, 0);

$content = "<div class='table-responsive'>";
$content .= "<table class='table table-striped table-hover'>";
$content .= "<thead>";
$content .= "<tr>";
$content .= "<th>#</th>";
$content .= "<th>Archivo</th>";
$content .= "<th>Adjunto</th>";
$content .= "<th>Json</th>";
$content .= "<th>Tamaño</th>";
$content .= "</tr>";
$content .= "</thead>";
$content .= "<tbody>";
$count = 0;
foreach ($files as $file) {
    $count++;
    $size = @$file['size'];
    $attachment = "";
    if (!empty($file['attachment'])) {
        $url = cdn_url($file["uri"]);
        $attachment = "<a href=\"{$url}\"target=\"_blank\">{$file['attachment']}</a>";
    }

    if (!empty($file['uri'])) {
        $identificationNumber = "No se pudo extraer";
        try {
            // Configura las credenciales de la API
            $keyFilePath = APPPATH . 'ThirdParty/Google2024/keys.json';
            $client = new DocumentProcessorServiceClient([
                'credentials' => $keyFilePath,
            ]);
            $project_id = "220756142912";
            $location = "us";
            $processor_id = "4d2c4e98b98a4508";
            $formattedName = $client->processorName($project_id, $location, $processor_id);

            $rutaCompleta = cdn_url($file["uri"]);
            $rawDocument = (new RawDocument())
                ->setContent(file_get_contents($rutaCompleta))
                ->setMimeType('application/pdf');

            $request = (new ProcessRequest())
                ->setName($formattedName)
                ->setRawDocument($rawDocument);

            $response = $client->processDocument($request);
            $document = $response->getDocument();
            $entities = $document->getEntities();

            // Buscar la entidad que corresponde al número de identificación
            $profile = array(
                "profile" => pk(),
                "reference" => @$file['reference']
            );
            foreach ($entities as $entity) {
                //echo("<br>entity->getType: " . $entity->getType());//identification|email
                /** Estos son los posibles tipos de entities
                 *  "profile",
                 * "first_name",
                 * "last_name",
                 * "id_number",
                 * "phone",
                 * "mobile_phone",
                 * "email",
                 * "residence_location",
                 * "birth_date",
                 * "blood_type",
                 * "campus_shift",
                 * "address",
                 * "neighborhood",
                 * "birth_place",
                 * "registration_date",
                 * "program",
                 * "health_provider",
                 * "ars_provider",
                 * "insurance_provider",
                 * "civil_status",
                 * "education_level",
                 * "institution",
                 * "municipality",
                 * "academic_level",
                 * "graduated",
                 * "degree_earned",
                 * "graduation_date",
                 * "family_member_full_name",
                 * "family_member_id_number",
                 * "family_member_phone",
                 * "family_member_mobile_phone",
                 * "family_member_email",
                 * "family_relationship",
                 * "company",
                 * "company_municipality",
                 * "job_position",
                 * "company_phone",
                 * "company_address",
                 * "job_start_date",
                 * "job_end_date",
                 * "source",
                 * "print_date",
                 */
                $profile[$entity->getType()] = $entity->getMentionText();
            }

            $jsonencode = json_encode($profile);
        } catch (Exception $e) {
            $jsonencode = json_encode(['error' => $e->getMessage()]);
        }
    }

    $content .= "<tr>";
    $content .= "<td>{$count}</td>";
    $content .= "<td>{$file['file']}</td>";
    $content .= "<td>{$attachment}</td>";
    $content .= "<td nowrap='true'><pre>{$jsonencode}</pre></td>";
    $content .= "<td>{$size}</td>";
    $content .= "</tr>";
}
$content .= "</tbody>";
$content .= "</table>";
$content .= "</div>";

$card = $bootstrap->get_Card("card-view-service", array(
    "title" => "Q10/Limpieza de archivos",
    "header-back" => $back,
    "header-add" => "/sie/q10files/list/" . lpk(),
    "content" => $content,
));
echo($card);
?>