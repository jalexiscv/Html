<?php
$mattachments = model("App\Modules\Storage\Models\Storage_Attachments");
$rows = $mattachments->where('reference', 'RECORDS-COMMITTES')->orderBy('created_at', 'DESC')->findAll();

?>


<div class="card ">
    <div class="card-header ">
        <h2>Listado de actas</h2>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <!--<th class="text-center">Adjunto</th>//-->
                <th class="text-center">Tipo</th>
                <th class="text-center">Fecha</th>
                <th class="text-center">Hora</th>
                <th class="text-center">Opciones</th>
            </tr>
            <?php foreach ($rows as $row) { ?>
                <?php
                if ($row["object"] === "M01") {
                    $format_type = "Acta de conformación del comité departamental distrital o municipal de gestión y desempeño";
                } else if ($row["object"] === "M02") {
                    $format_type = "Acta de conformación del comité institucional de gestión y desempeño";
                } else if ($row["object"] === "M03") {
                    $format_type = "Acta de conformación del comité departamental distrital o municipal de auditoria.";
                } else if ($row["object"] === "M04") {
                    $format_type = "Acta de conformación del comité institucional de coordinación de control interno";
                } else if ($row["object"] === "M05") {
                    $format_type = "Acta de reunión ordinaria";
                } else if ($row["object"] === "M06") {
                    $format_type = "Acta de reunión extra ordinaria";
                } else {
                    $format_type = "Formato desconocido {$row["object"]}";
                }
                ?>
                <tr>
                    <!--<td class="text-center"><?php echo($row["attachment"]); ?></td>//-->
                    <td><?php echo($format_type); ?></td>
                    <td class="text-center"><?php echo($row["date"]); ?></td>
                    <td class="text-center"><?php echo($row["time"]); ?></td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <a class="btn btn-outline-secondary" href="<?php echo($row["file"]); ?>" target="_blank"><i
                                        class="icon far fa-eye"></i> Ver</a>
                            <a class="btn btn-outline-secondary"
                               href="/disa/mipg/institutionality/delete/<?php echo($row["attachment"]); ?>"
                               target="_self"><i
                                        class="far fa-trash"></i> Eliminar</a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>









