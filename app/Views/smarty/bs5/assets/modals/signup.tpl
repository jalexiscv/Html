<div class="modal fade" id="modal-signup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-0 bgc-blue-l4">
                {include file="assets/modals/signup/index.tpl"}
                {include file="assets/modals/signup/success.tpl"}
            </div>
            <div class="modal-footer">
                {get_domain()} &copy; 2021
            </div>
        </div>
    </div>
</div>