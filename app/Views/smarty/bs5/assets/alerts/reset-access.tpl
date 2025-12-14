{$rsignup=get_rsignup()}
{if $rsignup=="access"}
    <div class="modal fade" id="modal-reset-token-access" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <input type="hidden" name="{$csrf_token}" value="{$csrf_hash}">
                <div class="modal-header">
                    <h5 class="modal-title">Notificación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-0 bgc-blue-l4 lh-6   text-center">
                    <i class="far fa-engine-warning fa-4x mb-3 animated rotateIn"></i>
                    <p>Ha iniciado sesión mediante un enlace de acceso, <u>recuerde actualizar su contraseña</u> para
                        recuperar el control
                        habitual de su cuenta, el enlace utilizado para acceder es de un único uso y no será funcional a
                        partir de
                        este momento, gracias por su atención.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button id="continue" type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">
                        <i class="far fa-sign-out-alt"></i>
                        Continuar
                    </button>
                </div>
            </div>
        </div>
    </div>
{literal}
    <script>
        $(document).ready(function () {
            var modalrat = new bootstrap.Modal(document.getElementById("modal-reset-token-access"), {});
            document.onreadystatechange = function () {
                modalrat.show();
            };
        })
    </script>
{/literal}
{elseif $rsignup=="expired"}
    <div class="modal fade" id="modal-reset-token-access" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <input type="hidden" name="{$csrf_token}" value="{$csrf_hash}">
                <div class="modal-header">
                    <h5 class="modal-title">¡Enlace expirado!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-0 bgc-blue-l4 lh-6   text-center">
                    <i class="far fa-engine-warning fa-4x mb-3 animated rotateIn"></i>
                    <p>El enlace de recuperación de contraseña ya ha sido usado o ha expirado, solicite uno nuevo eh
                        inténtelo
                        nuevamente. </p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button id="continue" type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">
                        <i class="far fa-sign-out-alt"></i>
                        Continuar
                    </button>
                </div>
            </div>
        </div>
    </div>
{literal}
    <script async>
        document.addEventListener('DOMContentLoaded', function () {
            var modalrat = new bootstrap.Modal(document.getElementById("modal-reset-token-access"), {});
            modalrat.show();
        });
    </script>
{/literal}
{/if}