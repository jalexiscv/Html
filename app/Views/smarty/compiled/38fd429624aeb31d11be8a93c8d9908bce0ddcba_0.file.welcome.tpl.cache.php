<?php
/* Smarty version 3.1.36, created on 2020-10-16 08:56:28
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\welcome.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5f89a68c63e152_97632760',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            '38fd429624aeb31d11be8a93c8d9908bce0ddcba' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\welcome.tpl',
                    1 => 1602712520,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(
            'file:_head.tpl' => 1,
            'file:_footer.tpl' => 1,
        ),
), false)) {
    function content_5f89a68c63e152_97632760(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '5714531235f89a68c637221_38970092';
        ?>
        <!doctype html>
        <html lang="en">
    <head>
        <?php $_smarty_tpl->_subTemplateRender("file:_head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
        ?>
        <link rel="stylesheet" type="text/css"
              href="<?php echo base_url("themes/default/application/views/default/pages/partials/page-login/@page-style.css"); ?>
">
    </head>
    <body>
    <?php if ((isset($_smarty_tpl->tpl_vars['page_trace']->value))) { ?>
        <?php echo $_smarty_tpl->tpl_vars['page_trace']->value; ?>

    <?php } ?>
    <div class="body-container">
        <div class="main-container container bg-transparent">
            <div role="main" class="main-content minh-100 justify-content-center">
                <div class="p-2 p-md-4">
                    <div class="row">
                        <div class="modal-dialog modal-notify modal-success" role="document">
                            <!--Content-->
                            <div class="modal-content">
                                <!--Header-->
                                <div class="modal-header">
                                    <p class="heading lead">Bienvenido!</p>

                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" class="white-text">&times;</span>
                                    </button>
                                </div>

                                <!--Body-->
                                <div class="modal-body">
                                    <div class="text-center">
                                        <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
                                        <p><?php echo $_smarty_tpl->tpl_vars['page_message']->value["message"]; ?>
                                        </p>
                                    </div>
                                </div>

                                <!--Footer-->
                                <div class="modal-footer justify-content-center">
                                    <a href="/home/" class="btn btn-success"><?php echo lang("App.Continue"); ?>
                                        <i class="far fa-gem ml-1 text-white"></i></a>
                                </div>
                            </div>
                            <!--/.Content-->
                        </div>
                    </div>
                </div>
                <div class="d-lg-none my-3 text-white-tp1 text-center">
                    <i class="fa fa-leaf text-success-l3 mr-1 text-110"></i> Ace Company &copy; 2020
                </div>
            </div>
        </div><!-- /main -->
    </div><!-- /.main-container -->
    <?php $_smarty_tpl->_subTemplateRender("file:_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
    ?>
    <?php echo '<script'; ?>
    type="text/javascript"
    src="<?php echo base_url("themes/default/application/views/default/pages/partials/page-login/@page-script.js"); ?>
    "><?php echo '</script'; ?>
    >
    </div><!-- /.body-container -->
    </body>
        </html><?php }
}
