<?php
/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create a new SQLite database connection
    $db = new SQLite3('db.sqlite');

    // Get the user ID from the request data
    $user_id = $_POST['user_id'];
    // Prepare and execute a SELECT statement to retrieve the chat history data
    $stmt = $db->prepare('SELECT human, ai FROM chat_history WHERE user_id = :user_id ORDER BY id ASC');
    $stmt->bindValue(':user_id', $user_id, SQLITE3_TEXT);
    $result = $stmt->execute();

    // Fetch the results and store them in an array
    $chat_history = array();
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $chat_history[] = $row;
    }

    // Close the database connection
    $db->close();

    // Set the HTTP response header to indicate that the response is JSON
    header('Content-Type: application/json');

    // Convert the chat history array to JSON and send it as the HTTP response body
    echo json_encode($chat_history);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Get the user ID to delete from the request body
    $user_id = $_GET['user'];

    // Create a new SQLite database connection
    $db = new SQLite3('db.sqlite');

    // Prepare and execute a DELETE statement to delete chat history records for the specified user ID
    $stmt = $db->prepare('DELETE FROM chat_history WHERE user_id = :user_id');
    $stmt->bindValue(':user_id', $user_id, SQLITE3_TEXT);
    $result = $stmt->execute();

    // Close the database connection
    $db->close();

    // Set the HTTP response status code to indicate success
    http_response_code(204); // No Content

}