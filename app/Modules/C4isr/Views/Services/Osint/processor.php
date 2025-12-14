<?php

//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Mails."));
$mmails = model("App\Modules\C4isr\Models\C4isr_Mails", false);
$mprofiles = model("App\Modules\C4isr\Models\C4isr_Profiles");

$number = $f->get_Value("number");
$url = "https://app.ipsfa.gob.ve/ipsfa/api/web/militar/{$number}";
$proxy_url = base64_url_encode($url);

$json = '';
while (empty($json)) {
    $contents = file_get_contents("https://www.cgine.com/proxy/index.php?q={$proxy_url}");
    if (!empty($contents)) {
        $json = json_decode($contents, true);
    }
    if (!$json) {
        sleep(3); // Pausa de 3 segundos antes de intentar de nuevo
    }
}

//print_r($json);

$persona = $json['Persona'];
$datobasico = $persona['DatoBasico'];
$correo = $persona['Correo'];
$datofisico = $persona['DatoFisico'];
$datofisionomico = $persona['DatoFisionomico'];
$direccion = $persona['Direccion'][0];
$datofinanciero = $persona['DatoFinanciero'][0];
$componente = $json['Componente'];
$grado = $json['Grado'];
$telefono = $persona['Telefono'];
$ip = $json['Tim']["ip"];

$familiares = $json['Familiar'];

$fullname = $datobasico['nombreprimero'] . " " . $datobasico['apellidoprimero'];
$c = view('App\Modules\C4isr\Views\Services\Osint\record', array("search" => $number,
    "cedula" => $datobasico['cedula'],
    "nropersona" => $datobasico['nropersona'],
    "nombreprimero" => $datobasico['nombreprimero'],
    "nombresegundo" => $datobasico['nombresegundo'],
    "apellidoprimero" => $datobasico['apellidoprimero'],
    "apellidosegundo" => $datobasico['apellidosegundo'],
    "fechanacimiento" => $datobasico['fechanacimiento'],
    "fechadefuncion" => $datobasico['fechadefuncion'],
    "sexo" => $datobasico['sexo'],
    "estadocivil" => $datobasico['estadocivil'],
    "nacionalidad" => $datobasico['nacionalidad'],
    "correo" => $correo['principal'],
    "telefono" => $telefono['domiciliario'],
    "estatura" => $datofisionomico['estatura'],
    "peso" => $datofisico['peso'],
    "talla" => $datofisico['talla'],
    "gruposanguineo" => $datofisionomico['gruposanguineo'],
    "colorpiel" => $datofisionomico['colorpiel'],
    "colorojos" => $datofisionomico['colorojos'],
    "colorcabello" => $datofisionomico['colorcabello'],
    "senasparticulares" => $datofisionomico['senaparticular'],
    "ciudad" => $direccion['ciudad'],
    "estado" => $direccion['estado'],
    "municipio" => $direccion['municipio'],
    "parroquia" => $direccion['parroquia'],
    "calleavenida" => $direccion['calleavenida'],
    "casa" => $direccion['casa'],
    "apartamento" => $direccion['apartamento'],
    "tipo" => $datofinanciero['tipo'],
    "institucion" => $datofinanciero['institucion'],
    "cuenta" => $datofinanciero['cuenta'],
    "prioridad" => $datofinanciero['prioridad'],
    "autorizado" => $datofinanciero['autorizado'],
    "titular" => $datofinanciero['titular'],
    "componente_nombre" => $componente['nombre'],
    "componente_descripcion" => $componente['descripcion'],
    "componente_abreviatura" => $componente['abreviatura'],
    "grado_nombre" => $grado['nombre'],
    "grado_descripcion" => $grado['descripcion'],
    "grado_abreviatura" => $grado['abreviatura'],
    "ip" => $ip
));

//$iframe = "<iframe id=\"raw\" src=\"{$url}\" width=\"100%\" height=\"640\" frameborder=\"0\" scrolling=\"yes\"></iframe>";
$back = "/c4isr/services/osint/" . lpk();
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "normal");
$smarty->assign("header", "OsinT (Raw) {$fullname}");
$smarty->assign("header_back", $back);
$smarty->assign("body", $c);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));


foreach ($familiares as $familiar) {
    //print_r($familiar);
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("type", "normal");
    $smarty->assign("header", "Familiar (Raw)");
    $smarty->assign("header_back", $back);
    $smarty->assign("body", view('App\Modules\C4isr\Views\Services\Osint\familiar', array("vector" => $familiar)));
    $smarty->assign("footer", null);
    $smarty->assign("file", __FILE__);
    echo($smarty->view('components/cards/index.tpl'));
}

?>