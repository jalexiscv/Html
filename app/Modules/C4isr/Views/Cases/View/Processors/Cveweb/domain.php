<?php
$b = service("bootstrap");
$s = service('strings');
$f = service("forms", array("lang" => "Cases."));

$case = $f->get_Value("case", "");
$type = $f->get_Value("type", "");
$country = $f->get_Value("country", "");

$variant = $f->get_Value("variant", "");
$domain = $f->get_Value("domain", "");
$query = $f->get_Value("query", "");
$limit = $f->get_Value("limit", 50);
$offset = $f->get_Value("offset", 0);

$explore = $f->get_Value("explore", "");

$url = "https://cve.cgine.com/cves/wsx.php?iso={$country}&D={$domain}&limit={$limit}&O={$offset}";
//exit();
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);  // La URL a la que quieres hacer la solicitud
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // Devuelve la respuesta como un string en lugar de imprimirla
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  // Sigue las redirecciones si las hay
$response = curl_exec($ch);
curl_close($ch);

$obj = json_decode($response, true);
//echo("<br>QUERY: " . @$obj["query"]);
$total_records = @$obj["total"];
if ($total_records > 0) {
    foreach ($obj["datas"] as $key => $value) {
        $mid = "modal-" . pk();
        $image = "/themes/assets/images/logos/server4x4.png";
        if (stripos($value['isp'], 'Telmex') !== false) {
            $image = "/themes/assets/images/logos/telmex4x4.png";
        } elseif (stripos($value['isp'], 'ETB') !== false) {
            $image = "/themes/assets/images/logos/etb4x4.png";
        } elseif (stripos($value['isp'], 'EPM') !== false) {
            $image = "/themes/assets/images/logos/epm4x4.png";
        } elseif (stripos($value['isp'], 'COLUMBUS NETWORKS') !== false) {
            $image = "/themes/assets/images/logos/columbusnetworks4x4.png";
        } elseif (stripos($value['isp'], 'COLOMBIA TELECOMUNICACIONES') !== false) {
            $image = "/themes/assets/images/logos/movistar4x4.png";
        } elseif (stripos($value['isp'], 'COMCEL ') !== false) {
            $image = "/themes/assets/images/logos/claro4x4.png";
        } elseif (stripos($value['isp'], 'Colombia Móvil') !== false) {
            $image = "/themes/assets/images/logos/tigo4x4.png";
        } elseif (stripos($value['isp'], 'Level 3 Parent') !== false) {
            $image = "/themes/assets/images/logos/tuscany4x4.png";
        } elseif (stripos($value['isp'], 'EDATEL') !== false) {
            $image = "/themes/assets/images/logos/edatel4x4.png";
        } elseif (stripos($value['isp'], 'TELEBUCARAMANGA ') !== false) {
            $image = "/themes/assets/images/logos/movistar4x4.png";
        } elseif (stripos($value['isp'], 'AZTECA ') !== false) {
            $image = "/themes/assets/images/logos/azteca4x4.png";
        }

        if (is_array($value['domains'])) {
            $domains = implode(",", $value['domains']);
        } else {
            $domains = $value['domains'];
        }
        $vulnerabilities = $value['vulnerabilities'];
        $cvulnerability = is_array($vulnerabilities) ? count($vulnerabilities) : " Sin vulnerabilidades";

        $vuln = !empty($vulnerabilities[0]['vuln']) ? $vulnerabilities[0]['vuln'] : '';
        $cvss = !empty($vulnerabilities[0]['cvss']) ? $vulnerabilities[0]['cvss'] : '';

        $add = "#";
        $viewer = "#";
        $ladd = $b::get_Link('ladd-' . $mid, array('href' => $add, 'icon' => ICON_ADD, 'text' => "Agregar", 'class' => 'btn-secondary w-100"'));
        $lviewer = $b::get_Link('lview-' . $mid, array('href' => $viewer, 'icon' => ICON_VIEW, 'text' => "Ver vulnerabilidades", 'class' => 'btn-primary w-100', 'data-bs-toggle' => "modal", 'data-bs-target' => "#{$mid}"));
        $options = $b::get_BtnGroup('options', array("content" => array($lviewer, $ladd), "class" => "btn-group-vertical w-100"));

        $details = "";
        $details .= "<b>IP</b>:{$value['ip_address']} </br>";
        $details .= "<b>Dominios</b>:{$domains} </br>";
        $details .= "<b>Host Name</b>: {$value['hostname']}</br>";
        $details .= "<b>Organización</b>: {$value['organization']}</br>";
        $details .= "<b>ISP</b>: {$value['isp']}</br>";
        $details .= "<b>Vulnerabilidades</b>: {$cvulnerability} </br>";

        $mvuln = "";
        if (is_array($vulnerabilities)) {
            $mvuln .= "<table class=\"table table-bordered table-hover\">";
            foreach ($vulnerabilities as $key => $vulnerability) {
                $mvuln .= "<tr>";
                $mvuln .= "<td class=\"w-50\"><a href=\"https://nvd.nist.gov/vuln/detail/{$vulnerability['vuln']}\" target=\"_blank\">{$vulnerability['vuln']}</a></td>";
                $mvuln .= "<td class=\"w-50 text-right\">{$vulnerability['cvss']}</td>";
                $mvuln .= "</tr>";
            }
            $mvuln .= "</table>";
        }

        $logo = $b::get_Img("cve-logo", array("src" => $image, "alt" => "CVE", "class" => "img-fluid w-100"));
        $col_logo = $b::get_Col("cve-col-logo", array("content" => $logo, "class" => "flex-fill col-1 p-0"));
        $col_details = $b::get_Col("cve-col-details", array("content" => $details, "class" => "flex-fill col-8 p-3  "));
        $col_options = $b::get_Col("cve-col", array("content" => $options, "class" => "flex-grow-1 p-3"));
        $row = $b::get_row("cve", array("content" => array($col_logo, $col_details, $col_options), "class" => "d-flex mb-3 border"));
        echo($row);

        $modal = $b->get_Modal($mid, array(
            "title" => "Vulnerabilidades: {$value['ip_address']}",
            "body" => "{$mvuln}"));
        echo($modal);

    }
} else {

}

//echo("<pre>");
//print_r($response);
//echo("</pre>");

?>
<?php if ($total_records > 0) { ?>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php
            $current_page = (int)(($offset / $limit) + 1);
            $total_pages = ceil($total_records / $limit);
            $start_page = max(1, $current_page - 5);
            $end_page = min($total_pages, $start_page + 9);

            // Variables adicionales
            $submited = "form_" . lpk();
            $case = $oid;
            //$type = "DATABREACHES";

            // Botón "Anterior"
            $prev_offset = max(0, $offset - $limit);
            $prev_disabled = $offset == 0 ? 'disabled' : '';
            echo "<li class='page-item $prev_disabled'>";
            echo "<form method='POST'>";
            echo "<input type='hidden' name='{$submited}_offset' value='$prev_offset'>";
            echo "<input type='hidden' name='{$submited}_limit' value='$limit'>";
            echo "<input type='hidden' name='submited' value='$submited'>";
            echo "<input type='hidden' name='{$submited}_case' value='$case'>";
            echo "<input type='hidden' name='{$submited}_type' value='$type'>";
            echo "<input type='hidden' name='{$submited}_country' value='$country'>";
            echo "<input type='hidden' name='{$submited}_explore' value='$explore'>";
            echo "<input type='hidden' name='{$submited}_variant' value='$variant'>";
            echo "<input type='hidden' name='{$submited}_domain' value='$domain'>";
            echo "<button type='submit' class='page-link'>&laquo; Anterior</button>";
            echo "</form>";
            echo "</li>";
            // Páginas
            for ($i = $start_page; $i <= $end_page; $i++) {
                $new_offset = $limit * ($i - 1);
                $active = $current_page == $i ? 'active' : '';
                echo "<li class='page-item $active'>";
                echo "<form method='POST'>";
                echo "<input type='hidden' name='{$submited}_offset' value='$new_offset'>";
                echo "<input type='hidden' name='{$submited}_limit' value='$limit'>";
                echo "<input type='hidden' name='submited' value='$submited'>";
                echo "<input type='hidden' name='{$submited}_case' value='$case'>";
                echo "<input type='hidden' name='{$submited}_type' value='$type'>";
                echo "<input type='hidden' name='{$submited}_country' value='$country'>";
                echo "<input type='hidden' name='{$submited}_explore' value='$explore'>";
                echo "<input type='hidden' name='{$submited}_variant' value='$variant'>";
                echo "<input type='hidden' name='{$submited}_domain' value='$domain'>";
                echo "<button type='submit' class='page-link'>$i</button>";
                echo "</form>";
                echo "</li>";
            }
            // Botón "Siguiente"
            $next_offset = min($total_records - $limit, $offset + $limit);
            $next_disabled = $offset + $limit >= $total_records ? 'disabled' : '';
            echo "<li class='page-item $next_disabled'>";
            echo "<form method='POST'>";
            echo "<input type='hidden' name='{$submited}_offset' value='$next_offset'>";
            echo "<input type='hidden' name='{$submited}_limit' value='$limit'>";
            echo "<input type='hidden' name='submited' value='$submited'>";
            echo "<input type='hidden' name='{$submited}_case' value='$case'>";
            echo "<input type='hidden' name='{$submited}_type' value='$type'>";
            echo "<input type='hidden' name='{$submited}_country' value='$country'>";
            echo "<input type='hidden' name='{$submited}_explore' value='$explore'>";
            echo "<input type='hidden' name='{$submited}_variant' value='$variant'>";
            echo "<input type='hidden' name='{$submited}_domain' value='$domain'>";
            echo "<button type='submit' class='page-link'>Siguiente &raquo;</button>";
            echo "</form>";
            echo "</li>";
            ?>
        </ul>
    </nav>
<?php } ?>