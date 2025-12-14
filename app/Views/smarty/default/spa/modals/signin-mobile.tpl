<div class="modal fade  modal-full" id="loginform" tabindex="-1" role="dialog" aria-labelledby="loginformLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content zendspace-bg-signin">
            <div class="modal-header">
                <h5 class="modal-title align-center opacity-1" id="loginformLabel">Bienvenid@</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-5">
                <div class="w-100 p-0">
                    <center>
                        <img src="/themes/assets/images/logos/zendspace-320x243.png" alt=""
                             class="pt-2 pl-0 pr-0 mt-0 mb-4" style="width: 150px;" width="280">
                    </center>
                </div>
                <form action="/spa/session/signin?t={$page_id}" class="" method="post" accept-charset="utf-8">
                    <input type="hidden" name="{csrf_token()}" value="{csrf_hash()}">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control zendspace-input-user" name="user"
                                   placeholder="{lang("App.Username")}" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="password" class="form-control zendspace-input-password" name="password"
                                   placeholder="{lang("App.Password")}" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-block zendspace-btn-primary">{lang("App.Sign-in")}</button>
                    </div>
                    <div class="clearfix">
                        <a href="#" class="zendspace-link-recover-password"> {lang("App.Recover-password")}</a>
                    </div>
                </form>
                <div class="text-center social-btn">
                    <a href="/facebook/authentication/" class="btn btn-block zendspace-btn-facebook"><i
                                class="fab fa-facebook-f"></i> {lang("App.Sign-in-with")} <b>Facebook</b></a>
                    <!--<a href="/twitter/authentication/" class="btn btn-info btn-block"><i class="fab fa-twitter"></i> {lang("App.Sign-in-with")} <b>Twitter</b></a>//-->
                    <!--<a href="#" class="btn btn-danger btn-block"><i class="fab fa-google-plus-g"></i> {lang("App.Sign-in-with")} <b>Google</b></a>//-->
                </div>
            </div>
            <div class="modal-footer bg-transparent zendspace-modal-footer">
                <center>
                    {lang("App.You-dont-have-anaccountyet")} <a href="/spa/clients/signup/"
                                                                class="zendspace-link-signup-here">{lang("App.sign-up-here")}</a><br>
                    <a href="/spa/therapists/signup/"
                       class="zendspace-link-signup-here">{lang("Spa.Do-you-want-to-work-with-us")}</a>
                </center>
            </div>
        </div>

    </div>
</div>
         