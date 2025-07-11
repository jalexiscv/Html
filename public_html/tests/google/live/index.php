<?php
require_once('../../../app/ThirdParty/Google/autoload.php');

use Google\Cloud\Storage\StorageClient;

echo("PRUEBA DE UPLOAD!");

$storage = new StorageClient(['keyFilePath' => '../../../app/ThirdParty/Google/keys.json']);
$bucket = $storage->bucket("cloud-engine");
$bucket->upload(fopen("test.jpg", 'r'), ['name' => "", 'predefinedAcl' => 'publicRead']);

use Google\Cloud\Video\LiveStream\V1\LivestreamServiceClient;
use Google\Cloud\Video\LiveStream\V1\Input;

/**
 * Creates an input. You send an input video stream to this endpoint.
 *
 * @param string $callingProjectId The project ID to run the API call under
 * @param string $location The location of the input
 * @param string $inputId The ID of the input to be created
 */
function create_input(
    string $callingProjectId,
    string $location,
    string $inputId
): void
{
    // Instantiate a client.
    $livestreamClient = new LivestreamServiceClient();

    $parent = $livestreamClient->locationName($callingProjectId, $location);
    $input = (new Input())
        ->setType(Input\Type::RTMP_PUSH);

    // Run the input creation request. The response is a long-running operation ID.
    $operationResponse = $livestreamClient->createInput($parent, $input, $inputId);
    $operationResponse->pollUntilComplete();
    if ($operationResponse->operationSucceeded()) {
        $result = $operationResponse->getResult();
        // Print results
        printf('Input: %s' . PHP_EOL, $result->getName());
    } else {
        $error = $operationResponse->getError();
        // handleError($error)
    }
}

?>