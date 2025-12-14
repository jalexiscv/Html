<?php
/* Smarty version 3.1.36, created on 2020-11-08 01:45:37
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\general\modals\access-granted.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5fa79411ea5828_51505304',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            '7e4f50cb67658e28a5629a2ea753e4c180c2867b' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\general\\modals\\access-granted.tpl',
                    1 => 1604568557,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(),
), false)) {
    function content_5fa79411ea5828_51505304(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '1089750105fa79411e973b8_94530193';
        ?>
        <div class="modal fade  " id="loginform-granted" tabindex="-1" role="dialog" aria-labelledby="loginformLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm modal-notify modal-success" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title heading lead" id="loginformLabel"><?php echo lang("App.Welcome"); ?>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
                            <p><?php echo lang("App.Access-granted"); ?>
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="/" class="btn btn-success float-right"><?php echo lang("App.Continue"); ?>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <?php echo '<script'; ?>
        type="text/javascript">
        $(window).on('load',function(){
        $('#loginform-granted').modal('show');
        });
        <?php echo '</script'; ?>
        ><?php }
}
