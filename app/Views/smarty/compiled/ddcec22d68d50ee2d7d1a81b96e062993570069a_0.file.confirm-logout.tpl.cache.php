<?php
/* Smarty version 3.1.36, created on 2020-11-07 01:53:34
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\acredit\modals\confirm-logout.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5fa6446ea1f5c8_44157889',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            'ddcec22d68d50ee2d7d1a81b96e062993570069a' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\acredit\\modals\\confirm-logout.tpl',
                    1 => 1604614164,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(),
), false)) {
    function content_5fa6446ea1f5c8_44157889(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '5764863725fa6446ea15727_75196135';
        ?>

        <!-- Central Modal Medium Danger -->
        <div class="modal fade" id="modal-logout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-notify modal-danger" role="document">
                <!--Content-->
                <div class="modal-content">
                    <!--Header-->
                    <div class="modal-header">
                        <p class="heading lead"><?php echo Lang("App.Confirm-logout"); ?>
                        </p>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>

                    <!--Body-->
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="far fa-engine-warning fa-4x mb-3 animated rotateIn"></i>
                            <p><?php ob_start();
                                echo Lang("App.Confirm-logout-message");
                                $_prefixVariable1 = ob_get_clean();
                                echo $_prefixVariable1; ?>
                            </p>
                        </div>
                    </div>

                    <!--Footer-->
                    <div class="modal-footer justify-content-center ">
                        <a href="/logout/" class="btn btn-danger text-white"><i
                                    class="far fa-sign-out-alt"></i> <?php echo Lang("App.Sign-off"); ?>
                        </a>
                        <a type="button" class="btn btn-outline-danger waves-effect text-danger"
                           data-dismiss="modal"><?php echo Lang("App.Cancel"); ?>
                        </a>
                    </div>
                </div>
                <!--/.Content-->
            </div>
        </div>
        <!-- Central Modal Medium Danger--><?php }
}
