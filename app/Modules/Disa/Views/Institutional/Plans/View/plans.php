<?php
$strings = service('strings');
$mplans = model('App\Modules\Disa\Models\Disa_Plans');
$plans = $mplans->where("plan_institutional", $plan)->findAll();

if (count($plans) > 0) {
    ?>
    <div class="col-12">


        <div class="card mt-3">
            <div class="card-header ">
                <h2><?php echo(count($plans)); ?> planes de acción relacionados</h2>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th nowrap="2">Plan de Acción</th>
                        <th>Description</th>
                    </tr>
                    <?php foreach ($plans as $key => $value) { ?>
                        <tr>
                            <td class="text-center"><a
                                        href="/disa/mipg/plans/view/<?php echo($value["plan"]); ?>"><?php echo($strings->get_ZeroFill($value["order"], 4)); ?></a>
                            </td>
                            <td><?php echo(urldecode($value["description"])); ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
<?php } else {
    ?>
    <div class="col-12">
        <div class="alert alert-secondary" role="alert">
            No existen planes de trabajo relacionados.
        </div>
    </div>
<?php } ?>