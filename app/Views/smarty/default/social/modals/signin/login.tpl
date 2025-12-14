<!--[social-modals-signin-login]-->
<!-- show this in desktop -->
<div class="d-none d-lg-block col-md-6 offset-md-3 mt-lg-4 px-0">
    <h4 class="text-dark-tp4 border-b-1 brc-secondary-l2 pb-1 text-130">
        <i class="fa fa-coffee text-orange-m1 mr-1"></i>
        Bienvenid@
    </h4>
</div>

<!-- show this in mobile device -->
<div class="d-lg-none text-secondary-m1 my-4 text-center">
    <a href="/social/">
        <i class="fa fa-leaf text-success-m2 text-200 mb-1"></i>
    </a>
    <h1 class="text-170">
        <span class="text-blue-d1">
            Ace <span class="text-80 text-dark-tp3">Application</span>
        </span>
    </h1>
    Bienvenid@
</div>


<form autocomplete="on" class="form-row mt-4" action="/social/session/signin/{$page_id}" method="POST"
      accept-charset="utf-8">
    <input type="hidden" name="{$csrf_token}" value="{$csrf_hash}">
    <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
        <div class="d-flex align-items-center input-floating-label text-blue brc-blue-m2">
            <input name="user" placeholder="{lang("App.Username")}" type="text"
                   class="form-control form-control-lg pr-4 shadow-none" id="user"/>
            <i class="fa fa-user text-grey-m2 ml-n4"></i>
            <label class="floating-label text-grey-l1 ml-n3" for="id-login-username">Usuario</label>
        </div>
    </div>
    <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-2 mt-md-1">
        <div class="d-flex align-items-center input-floating-label text-blue brc-blue-m2">
            <input name="password" placeholder="{lang("App.Password")}" type="password"
                   class="form-control form-control-lg pr-4 shadow-none" id="password"/>
            <i class="fa fa-key text-grey-m2 ml-n4"></i>
            <label class="floating-label text-grey-l1 ml-n3" for="id-login-password">Contraseña</label>
        </div>
    </div>
    <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 text-right text-md-right mt-n2 mb-1">
        <a href="#" class="text-primary-m1 text-95" data-toggle="tab" data-target="#id-tab-forgot">
            ¿{lang("App.Forgot-Password")}?
        </a>
    </div>
    <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
        <label class="d-inline-block mt-3 mb-0 text-dark-l1">
            <input type="checkbox" class="mr-1" id="id-remember-me"/>
            {lang("App.Remember-me")}
        </label>
        <input type="submit" class="btn btn-primary btn-block px-4 btn-bold mt-2 mb-1" value="{lang("App.Sign-in")}">
    </div>
</form>


<div class="form-row">
    <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 d-flex flex-column align-items-center justify-content-center">
        <hr class="brc-default-l2 mt-0 mb-1 w-100"/>
        <div class="p-0 px-md-2 my-lg-2 text-dark-tp3">
            ¿No eres miembro?
            <a class="text-success-m1 text-600 mx-1" data-toggle="tab" data-target="#id-tab-signup" href="#">
                Registrate!
            </a>
        </div>
        <hr class="brc-default-l2 w-100 mb-1"/>
        <div class="mt-n4 bgc-white-tp2 pt-0  text-secondary-d3 text-90">o inicie sesión utilizando</div>
        <div class="my-2">
            <button type="button"
                    class="btn btn-bgc-white btn-lighter-primary btn-h-primary btn-a-primary border-2 radius-round btn-lg mx-1">
                <i class="fab fa-facebook-f text-110"></i>
            </button>
            <button type="button"
                    class="btn btn-bgc-white btn-lighter-info btn-h-info btn-a-info border-2 radius-round btn-lg px-25 mx-1">
                <i class="fab fa-twitter text-110"></i>
            </button>
            <button type="button"
                    class="btn btn-bgc-white btn-lighter-red btn-h-red btn-a-red border-2 radius-round btn-lg px-25 mx-1">
                <i class="fab fa-google text-110"></i>
            </button>
        </div>

    </div>
</div>
<!--[/social-modals-signin-login]-->