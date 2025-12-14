<?php
/*
 * Copyright (c) 2023. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

$b = service("bootstrap");
$s = service('strings');
$f = service("forms", array("lang" => "Cases."));

$explore = $f->get_Value("explore", "");
$html = "";

$case = $f->get_Value("case", "");
$type = $f->get_Value("type", "");
$explore = $f->get_Value("explore", "");
$query = $f->get_Value("query", "");

echo("<h2>Consulta: " . $query . "</h2>");
echo("<hr>");

$url = "http://186.84.174.105/search.php?t=" . time() . "&q={$query}";
//exit();
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);  // La URL a la que quieres hacer la solicitud
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // Devuelve la respuesta como un string en lugar de imprimirla
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  // Sigue las redirecciones si las hay
$response = curl_exec($ch);
curl_close($ch);

$jsons = json_decode($response, true);

echo("<table class=\"table table-bordered\">");
echo("<tr>");
echo("<th class=\"p-1 text-center\">#</th>");
echo("<th class=\"p-1 text-center\">Archivo</th>");
echo("<th class=\"p-1\">Onion</th>");
echo("<th class=\"p-1 text-center\">Opciones</th>");
echo("</tr>");
$count = 0;
foreach ($jsons as $json) {
    $json = str_replace("'", "\"", $json);
    $vector = json_decode($json);
    if (isset($vector->file) && !empty($vector->file)) {
        $count++;
        $mid = "modal-" . pk();
        $file = safe_urldecode($vector->file);
        $path = safe_urldecode($vector->path);
        $fullpath = "http://186.84.174.105/{$path}/{$file}";
        $pathonion = get_c4isr_onion($path, 64);
        $onion = "<a href=\"{$pathonion}\" target=\"_blank\">{$pathonion}</a>";
        $line = $vector->line;
        $context = safe_urldecode($vector->context);

        $add = "#";
        $viewer = "#";
        $ladd = $b::get_Link('ladd-' . $mid, array('href' => $add, 'icon' => ICON_ADD, 'text' => "Agregar", 'class' => 'btn-secondary w-100"'));
        $lviewer = $b::get_Link('lview-' . $mid, array('href' => $viewer, 'icon' => ICON_VIEW, 'text' => "Ver vulnerabilidades", 'class' => 'btn-primary w-100', 'data-bs-toggle' => "modal", 'data-bs-target' => "#{$mid}"));
        $options = $b::get_BtnGroup('options', array("content" => array($lviewer, $ladd), "class" => "btn-group-vertical w-100"));

        $modal = $b->get_Modal($mid, array(
                "title" => "Archivo original preservado",
                "body" => "<iframe src=\"{$fullpath}\" width=\"100%\" height=\"400px\" scrolling=\"auto\"></iframe>"
            )
        );

        echo("<tr>");
        echo("<td class=\"p-1 text-center\">{$count}</td>");
        echo("<td class=\"p-1 text-center\" wrap>Linea: {$line}</td>");
        echo("<td class=\"p-1\">{$onion}<div class=\"p-1\" style=\"line-height: 1rem;font-size: 1rem;border: 1px solid #cccccc;background-color: #ede8d9;width:480px;overflow:scroll;\">{$context}</div>{$modal}</td>");
        echo("<td class=\"p-1 text-center\">{$options}</td>");
        echo("</tr>");
    }
}
echo("</table>");

//print_r($jsons);


?>