<?php
/* Smarty version 3.1.36, created on 2020-11-04 14:34:09
  from 'C:\xampp\htdocs\Higgs-dominance\app\Views\smarty\default\modals\signin.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array(
    'version' => '3.1.36',
    'unifunc' => 'content_5fa30231c7e876_08435418',
    'has_nocache_code' => false,
    'file_dependency' =>
        array(
            'ddf63ec0e1c814350a05a5591701d2fe21d495fa' =>
                array(
                    0 => 'C:\\xampp\\htdocs\\Higgs-dominance\\app\\Views\\smarty\\default\\modals\\signin.tpl',
                    1 => 1604508896,
                    2 => 'file',
                ),
        ),
    'includes' =>
        array(),
), false)) {
    function content_5fa30231c7e876_08435418(Smarty_Internal_Template $_smarty_tpl)
    {
        $_smarty_tpl->compiled->nocache_hash = '7773884485fa30231c7b518_88350377';
        ?>
        <div class="modal fade  " id="loginform" tabindex="-1" role="dialog" aria-labelledby="loginformLabel"
             aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginformLabel">Iniciar sesión</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/social/session/signin/<?php echo $_smarty_tpl->tpl_vars['page_id']->value; ?>
" class="" method="post" accept-charset="utf-8">
                        <input type="hidden" name="<?php echo csrf_token(); ?>
" value="<?php echo csrf_hash(); ?>
">
                        <div class="text-center social-btn">
                            <a href="/facebook/authentication/" class="btn btn-primary btn-block"><i
                                        class="fab fa-facebook-f"></i> <?php echo lang("App.Sign-in-with"); ?>
                                <b>Facebook</b></a>
                            <!--<a href="/twitter/authentication/" class="btn btn-info btn-block"><i class="fab fa-twitter"></i> <?php echo lang("App.Sign-in-with"); ?>
 <b>Twitter</b></a>//-->
                            <!--<a href="#" class="btn btn-danger btn-block"><i class="fab fa-google-plus-g"></i> <?php echo lang("App.Sign-in-with"); ?>
 <b>Google</b></a>//-->
                        </div>
                        <div class="or-seperator"><i>o</i></div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                        <span class="input-group-text">
                        <span class="fa fa-user"></span>
                        </span>
                                </div>
                                <input type="text" class="form-control" name="user"
                                       placeholder="<?php echo lang("App.Username"); ?>
" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                        <span class="input-group-text">
                        <i class="fa fa-lock"></i>
                        </span>
                                </div>
                                <input type="password" class="form-control" name="password"
                                       placeholder="<?php echo lang("App.Password"); ?>
" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit"
                                    class="btn btn-success btn-block login-btn"><?php echo lang("App.Sign-in"); ?>
                            </button>
                        </div>
                        <div class="clearfix">
                            <label class="float-left form-check-label"><input
                                        type="checkbox"> <?php echo lang("App.Remember-me"); ?>
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="#" class="float-right text-success"><?php echo lang("App.Forgot-Password"); ?>
                        ?</a>
                </div>
            </div>

        </div>
        </div><?php }
}
