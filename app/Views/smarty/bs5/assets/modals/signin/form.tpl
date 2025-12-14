<div class="d-none d-lg-block col-md-6 offset-md-3 mt-lg-4 px-0">
    <h4 class=" border-b-1 brc-secondary-l2 pb-1  ">
        <i class="fa fa-coffee text-orange-m1 mr-1"></i>
        Bienvenid@
    </h4>
</div>
<form id="form-signin" autocomplete="on" class="form-row mt-4" method="POST" accept-charset="utf-8">
    <input type="hidden" name="{$csrf_token}" value="{$csrf_hash}">
    <div class="mb-3">
        <label class="form-label">{lang("App.Email")}</label>
        <input class="form-control form-control-lg" type="email" name="modal-email" id="modal-email"
               placeholder="Ejemplo: usuario@gmail.com">
        <div class="invalid-feedback">
            Incorrecto o no registrado!.
        </div>
        <div class="valid-feedback">
            Usuario existente!
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">{lang("App.Password")}</label>
        <input class="form-control form-control-lg" type="password" name="modal-password" id="modal-password"
               placeholder="Contraseña">
        <div class="invalid-feedback">
            Contraseña incorrecta!.
        </div>
        <div class="valid-feedback">
            Contraseña aceptada!
        </div>
        <small>
            <a href="#" data-bs-toggle="modal" data-bs-dismiss="modal"
               data-bs-target="#modal-reset">¿{lang("App.Forgot-Password")}?</a>
        </small>
    </div>
    <div>
        <label class="form-check">
            <input class="form-check-input" type="checkbox" value="remember-me" name="remember-me" checked="">
            <span class="form-check-label">{lang("App.Remember-me")}</span>
        </label>
    </div>
    <div class="text-center mt-3">
        <button id="btnmodalsignup" type="button" class="btn btn-lg btn-secondary" data-bs-toggle="modal"
                data-bs-target="#modal-signup" data-bs-dismiss="modal">{lang("App.sign-up")}</button>
        <button id="btnmodalsignin" type="button" class="btn btn-lg btn-primary">{lang("App.Sign-in")}</button>
    </div>
</form>
{literal}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            var btnmodalsignin = document.getElementById('btnmodalsignin');
            btnmodalsignin.addEventListener('click', function () {
                signin('modal-email', 'modal-password');
            });
        });
    </script>
{/literal}