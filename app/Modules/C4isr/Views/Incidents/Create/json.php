<?php
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Request]-----------------------------------------------------------------------------
$case = $request->getVar('case');
$mail = $request->getVar("mail");
$alias = $request->getVar("alias");
$mincidents = model("App\Modules\C4isr\Models\C4isr_Incidents");

// Agregar el DATAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA

if (!empty($mail)) {
    $incident = $mincidents->where('case', $case)->where('mail', $mail)->first();
    if ($incident) {
        $response = array(
            "messages" => "Ya existe un incidente con este caso y correo",
            "status" => "error",
            "case" => $case,
            "mail" => $mail,
        );
    } else {
        $mmails = model('App\Modules\C4isr\Models\C4isr_Mails');
        $mail = $mmails->query_UnionMail($mail);

        $d = array(
            "incident" => pk(),
            "case" => $case,
            "mail" => $mail['mail'],
            "alias" => null,
            "reference" => $mail['email'],
            "author" => $authentication->get_User(),
        );
        $create = $mincidents->insert($d);
        $response = array(
            "messages" => "Incidene registrado!",
            "status" => "success",
            "case" => $case,
            "mail" => $mail,
        );
    }
} elseif (!empty($alias)) {
    $incident = $mincidents->where('case', $case)->where('alias', $alias)->first();
    if ($incident) {
        $response = array(
            "messages" => "Ya existe un incidente con este caso y correo",
            "status" => "error",
            "case" => $case,
            "mail" => $alias,
        );
    } else {
        $maliases = model('App\Modules\C4isr\Models\C4isr_Aliases');
        $alias = $maliases->query_UnionAlias($alias);
        $d = array(
            "incident" => pk(),
            "case" => $case,
            "mail" => null,
            "alias" => $alias['alias'],
            "reference" => $alias['user'],
            "author" => $authentication->get_User(),
        );
        $create = $mincidents->insert($d);
        $response = array(
            "messages" => "Incidene registrado!",
            "status" => "success",
            "case" => $case,
            "mail" => $alias,
        );
    }
} else {
    $response = array(
        "messages" => "Tipo de incidente desconocido!",
        "status" => "Error",
    );
}


echo(json_encode($response));
?>