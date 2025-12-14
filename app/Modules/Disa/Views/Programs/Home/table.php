<?php
/*
 * Copyright (c) 2022. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

use App\Libraries\Strings;

$strings = new Strings();
$mprograms = model("\App\Modules\Disa\Models\Disa_Programs");
$programs = $mprograms->where("politic", $oid)->findAll();

?>
<div class="row ">
    <div class="col-12 activities pb-1">
        <table width="100%" class="table table-striped table-hover activities" border="1">
            <tr>
                <th class="th" nowrap>Programa</th>
                <th class="th">Nombre</th>
                <th class="th">Descripción</th>
                <th class="th" nowrap>Opciones</th>
            </tr>
            <?php foreach ($programs as $p) { ?>
                <?php $name = $strings->get_Clear(urldecode($p["name"])); ?>
                <?php $description = $strings->get_Clear(urldecode($p["description"])); ?>
                <tr>
                    <td class="order  " nowrap>
                        <?php echo($strings->get_ZeroFill($p["order"], 2)); ?>
                    </td>
                    <td class="name">
                        <?php echo($name); ?>
                    </td>
                    <td class="description">
                        <?php echo($description); ?>
                    </td>
                    <td nowrap="" class="text-center p-2">
                        <div class="btn-group" role="group">
                            <a class="btn btn-outline-secondary"
                               href="/disa/programs/view/<?php echo($p["program"]); ?>"
                               target="_self">
                                <i class="icon far fa-eye"></i>
                                <span class="button-text">Diagnostico</span>
                            </a>
                            <a class="btn btn-outline-secondary"
                               href="/disa/programs/edit/<?php echo($p["program"]); ?>" target="_self">
                                <i class="icon far fa-edit"></i>
                                <span class="button-text">Editar</span>
                            </a>
                            <a class="btn btn-outline-secondary"
                               href="/disa/programs/delete/<?php echo($p["program"]); ?>" target="_self">
                                <i class="far fa-trash"></i>
                                <span class="button-text">Eliminar</span>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>