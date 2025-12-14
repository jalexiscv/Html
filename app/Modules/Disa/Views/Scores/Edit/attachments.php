<?php
/*
 * Copyright (c) 2023. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

$mattachments = model("App\Modules\Storage\Models\Storage_Attachments");
$rows = $mattachments
    ->where('object', $oid)
    ->where('reference', 'EVIDENCES')
    ->orderBy('created_at', 'DESC')
    ->findAll();

?>
<div class="card ">
    <div class="card-header ">
        <h2>Evidencias de la recalificación</h2>
        <div class="card-toolbar">
            <a href="/disa/mipg/scores/attachments/create/<?php echo($oid); ?>"
               class="card-toolbar-btn bg-primary border-primary">
                <i class="fa-regular fa-paperclip"></i>
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if (is_array($rows) && count($rows) > 0) { ?>
            <table class="table table-bordered">
                <tr>
                    <th class="text-center">Adjunto</th>
                    <th class="text-center">Tipo</th>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Hora</th>
                    <th class="text-center w-auto">Opciones</th>
                </tr>
                <?php foreach ($rows as $row) { ?>
                    <tr>
                        <td class="text-center"><a class="" href="<?php echo($row["file"]); ?>"
                                                   target="_blank"><?php echo($row["attachment"]); ?></a></td>
                        <td class="text-center"><?php echo($row["type"]); ?></td>
                        <td class="text-center"><?php echo($row["date"]); ?></td>
                        <td class="text-center"><?php echo($row["time"]); ?></td>
                        <td class="text-end">
                            <div class="btn-group" role="group">
                                <a class="btn btn-outline-secondary" href="<?php echo($row["file"]); ?>"
                                   target="_blank"><i
                                            class="icon far fa-eye"></i> Ver</a>
                                <a class="btn btn-outline-secondary"
                                   href="/disa/mipg/scores/attachments/delete/<?php echo($row["attachment"]); ?>"
                                   target="_self"><i
                                            class="far fa-trash"></i> Eliminar</a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="fas fa-bell-exclamation me-3 fa-2x text-warning"></i>
                <div class="content">
                    <b>Advertencia</b>:
                    Es necesario que adjunte evidencias que sustenten el valor de la recalificación ingresado, en este
                    momento no existen evidencias adjuntas.
                    [ <a href="/disa/mipg/scores/attachments/create/<?php echo($oid); ?>">Adjuntar evidencia</a> ]
                </div>
            </div>
        <?php } ?>
    </div>
</div>