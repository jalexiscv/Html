<div class="modal fade" id="modalsignout" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <input type="hidden" name="{$csrf_token}" value="{$csrf_hash}">
            <div class="modal-header">
                <h5 class="modal-title">¿Realmente desea salir?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-0 bgc-blue-l4 lh-6   text-center">
                {include file="assets/modals/signout/index.tpl"}
            </div>
            <div class="modal-footer justify-content-center">
                <a id="submit_signout" class="btn btn-danger text-white" href="/security/session/logout/end">
                    <i class="far fa-sign-out-alt"></i> Cerrar Sesión
                </a>
                <a type="button" class="btn btn-outline-danger waves-effect text-danger"
                   data-bs-dismiss="modal">Cancelar</a>
            </div>
        </div>
    </div>
</div>