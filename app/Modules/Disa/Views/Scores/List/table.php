<?php
$strings = service("strings");
$mscores = model("\App\Modules\Disa\Models\Disa_Scores", true);
$mfields = model('App\Modules\Disa\Models\Disa_Users_Fields');
$scores = $mscores->get_ListByActivity($oid);
?>
<style>
    .activities-table {
        border: 1px solid #cccccc;
    }

    .activities th {
        font-size: 14px;
        line-height: 14px;
        text-align: center;
        vertical-align: middle;
        padding: 10px;
    }

    .activities table td {
        padding: 0.5px;
    }


    .activities-table .title {
        font-size: 14px;
        line-height: 14px;
        text-align: center;
        border: 1px solid #cccccc;
        padding: 10px;
        height: 64px;
    }

    .activities-table .link {
        font-size: 14px;
        line-height: 14px;
        text-align: center;
        border: 1px solid #cccccc;
        padding: 10px;
    }

    .activities-table .graph {
        width: 100%;
        border: 1px solid #cccccc;
        height: 150px;
    }

    .activities .order {
        font-size: 12px;
        line-height: 12px;
    }

    .activities .description {
        font-size: 14px;
        line-height: 14px;
        padding: 10px;
    }


    .activities .description p {
        font-size: 1rem;
        line-height: 1rem;
        padding: 0px;
    }

    .activities .criteria {
        font-size: 14px;
        line-height: 14px;
        padding: 10px;
    }

    .activities .evaluation {
        font-size: 10px;
        line-height: 10px;
    }

    .activities .period {
        font-size: 12px;
        line-height: 12px;
        text-align: center;
        vertical-align: middle;
    }

    .activities .order {
        font-size: 1rem;
        line-height: 1rem;
        text-align: center;
        vertical-align: middle;
    }

    .activities .score {
        font-size: 2rem;
        /* line-height: 2rem; */
        text-align: center;
        /* vertical-align: middle; */
        padding: 10px;
        border-left: 1px solid #cccccc;
        border-right: 1px solid #cccccc;
        /* margin: 3px; */
        /* display: block; */
    }

</style>
<div class="row ">
    <div class="col-12 activities pb-1">
        <table width="100%" class="table table-striped table-hover activities" border="1">
            <tr>
                <th>#</th>
                <th>Puntaje</th>
                <th>Detalles</th>
                <th>Opciones</th>
            </tr>
            <?php $count = count($scores) + 1; ?>
            <?php foreach ($scores as $d) { ?>
                <?php $count--; ?>
                <tr>
                    <td class="order"><?php echo($count); ?></td>
                    <td class="score align-middle"><?php echo(round($d["value"], 0)); ?></td>
                    <td class="description">
                        <?php echo($strings->get_Striptags(urldecode($d["details"]))); ?>
                        <br>Fecha de calificación: <?php echo($d["created_at"]); ?>
                        <?php $profile = $mfields->get_Profile($d["author"]); ?>
                        <br><b>Responsable</b>: <?php echo($profile['name']); ?>
                    </td>
                    <td class="">
                        <div class="btn-group" role="group">
                            <a class="btn btn-outline-secondary"
                               href="/disa/mipg/scores/edit/<?php echo($d["score"]); ?>" target="_self"><i
                                        class="icon far fa-edit"></i><span class="button-text">Editar</span></a>
                            <a class="btn btn-outline-secondary"
                               href="/disa/mipg/scores/delete/<?php echo($d["score"]); ?>" target="_self"><i
                                        class="far fa-trash"></i><span class="button-text">Eliminar</span></a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>