<?php
$strings = service("strings");
$mvulnerabilities = model("App\Modules\C4isr\Models\C4isr_Vulnerabilities");
//$mail = $oid;
$result = $mvulnerabilities->where("alias", $oid)->orWhere("mail", $oid)->findAll();
//print_r($result);

echo("<table class=\"table table-bordered\">");
echo("<tr>");
echo("<th class=\"px-3 text-center\">Contraseña</th>");
echo("<th class=\"px-3 text-center\">Fecha de Vulneración</th>");
echo("</tr>");
foreach ($result as $key => $value) {
    echo("<tr>");
    echo("<td class=\"px-3\">" . $strings->get_URLDecode($value["password"]) . "</td>");
    echo("<td class=\"text-center\">" . $value["created_at"] . "</td>");
    echo("</tr>");
}
echo("</table>");
?>