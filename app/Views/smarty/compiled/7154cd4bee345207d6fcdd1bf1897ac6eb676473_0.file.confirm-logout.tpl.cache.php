<?php
/* Smarty version 3.1.36, created on 2020-11-08 07:39:01
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\general\modals\confirm-logout.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5fa7e6e5639d45_71313563',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            '7154cd4bee345207d6fcdd1bf1897ac6eb676473' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\general\\modals\\confirm-logout.tpl',
                    1 => 1595411159,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(),
), false)) {
    function content_5fa7e6e5639d45_71313563(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '6763511955fa7e6e5636f53_54462434';
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
