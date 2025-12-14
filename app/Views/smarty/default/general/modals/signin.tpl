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

                <form action="/social/session/signin/{$page_id}" class="" method="POST" accept-charset="utf-8">
                    <input type="hidden" name="{$csrf_token}" value="{$csrf_hash}">
                    <div class="text-center social-btn">
                        <a href="/facebook/authentication/" class="btn btn-primary btn-block"><i
                                    class="fab fa-facebook-f"></i> {lang("App.Sign-in-with")} <b>Facebook</b></a>
                        <!--<a href="/twitter/authentication/" class="btn btn-info btn-block"><i class="fab fa-twitter"></i> {lang("App.Sign-in-with")} <b>Twitter</b></a>//-->
                        <!--<a href="#" class="btn btn-danger btn-block"><i class="fab fa-google-plus-g"></i> {lang("App.Sign-in-with")} <b>Google</b></a>//-->
                    </div>
                    <div class="or-seperator"><i>o</i></div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                        <span class="input-group-text">
                        <span class="fa fa-user"></span>
                        </span>
                            </div>
                            <input type="text" class="form-control" name="user" placeholder="{lang("App.Username")}"
                                   required="required">
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
                                   placeholder="{lang("App.Password")}" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block login-btn">{lang("App.Sign-in")}</button>
                    </div>
                    <div class="clearfix">
                        <label class="float-left form-check-label"><input type="checkbox"> {lang("App.Remember-me")}
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" class="float-right text-success">{lang("App.Forgot-Password")}?</a>
            </div>
        </div>

    </div>
</div>