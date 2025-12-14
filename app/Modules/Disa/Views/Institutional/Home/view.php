<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

//generate_disa_permissions();

?>
<div class="card ">
    <div class="card-header">
        <?php echo(lang("App.Settings")); ?>
    </div>
    <div class="card-body">


        <div class="row  row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-1 row-cols-1  text-center shortcuts">
            <div class="col mb-3">
                <div class="card mb-4 rounded-3 shadow-sm h-100">
                    <div class="card-header">
                        <h4 class="my-0 fw-normal">Planes institucionales</h4>
                    </div>
                    <div class="card-body pb-0">
                        <i class="fas fa-tasks fa-4x"></i>
                    </div>
                    <div class="card-footer p-2">
                        <a href="/disa/institutional/plans/list/<?php echo(lpk()); ?>"
                           class="w-100 btn btn-lg btn-orange">Acceder</a>
                    </div>
                </div>
            </div>

        </div>


    </div>
</div>