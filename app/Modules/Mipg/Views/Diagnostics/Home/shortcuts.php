<?php



//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$strings = service("strings");
$mdiagnostics = model('App\Modules\Mipg\Models\Mipg_Diagnostics');
$mpolitics = model('App\Modules\Mipg\Models\Mipg_Politics');
//[data]---------------------------------------------------------------------------------------------------------------
$diagnostics = $mdiagnostics->where("politic", $oid)->orderBy("order", "ASC")->findAll();
$politic = $mpolitics->where("politic", $oid)->first();
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/mipg/politics/home/{$politic['dimension']}";

$code = "<div class=\"row\trow-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-1 row-cols-1\ttext-center shortcuts\">\n";
$count = 0;
foreach ($diagnostics as $diagnostic) {
    $count++;
    $score = $mdiagnostics->get_Score($diagnostic['diagnostic']);
    $percentage = $score;
    $title = $diagnostic['name'];
    $subtitle = "$percentage%";
    $code .= "\t\t<div class=\"col mb-1\">\n";
    $code .= "<div class=\"card mb-1\">\n";
    $code .= "\t<div class=\"card-body d-flex align-items-center position-relative\">\n";
    $code .= "\t\t<span class=\"card-badge bg-secondary absolute float-right opacity-1 \">{$count}</span>\n";
    $code .= "<div class=\"row w-100 p-0 m-0\">\n";
    $code .= "<div class=\"col-12 d-flex align-items-center justify-content-center\">\n";
    $code .= "<a href=\"/mipg/components/home/{$diagnostic['diagnostic']}\" class=\"stretched-link\">\n";
    $code .= "\t\t\t\t\t\t<canvas id=\"heatGraph-{$diagnostic['diagnostic']}\" class=\"heatgraph-canvas\" height=\"254px\" data-type=\"Diagnostico\" data-title=\"$title\"  data-subtitle=\"$subtitle\" data-percentage=\"$percentage\"></canvas>\n";
    $code .= "</a>\n";
    $code .= "</div>\n";
    $code .= "</div>\n";
    $code .= "</div>\n";
    $code .= "</div>\n";
    $code .= "\t</div>\n";
}
$code .= "</div>\n";

$title = $strings->get_Striptags($politic["name"]);
$message = $strings->get_Striptags($politic["description"]);
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang('Diagnostics.list-title'),
    "header-back" => $back,
    //"header-add" => '/mipg/diagnostics/create/' . $oid,
    "header-list" => '/mipg/diagnostics/list/' . $oid,
    "alert" => array(
        'type' => 'info',
        'title' => $title,
        'message' => $message
    ),
    "content" => $code,
));
echo($card);
//[info]----------------------------------------------------------------------------------------------------------------
$link1 = "<a class=\"btn btn-secondary\" data-bs-toggle=\"modal\" data-bs-target=\"#static-normative\">Normativa</a>";
$link2 = "<a class='btn btn-secondary mx-1'  data-bs-toggle=\"modal\" data-bs-target=\"#static-tools\" >Herramientas</a>";
$btns = $link1 . $link2;


$info = $bootstrap->get_Card("card-view-service", array(
    "alert" => array('type' => 'info', 'title' => "", 'message' => $btns, 'class' => 'mb-0'),
));
echo($info);


$info = $bootstrap->get_Card("card-view-service", array(
    "alert" => array('type' => 'secondary', 'title' => lang("Mipg_Diagnostics.mipg-diagnostic-info-title"), 'message' => lang("Mipg_Diagnostics.mipg-diagnostic-info-message"), 'class' => 'mb-0'),
));
//echo($info);
?>
<div id="static-normative" class="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Normative</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo @$politic['normative']; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continuar</button>
            </div>
        </div>
    </div>
</div>
<div id="static-tools" class="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Herramientas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo @$politic['tools']; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continuar</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.title = "<?php echo("Política: " . $politic['name']);?>";
    });
</script>