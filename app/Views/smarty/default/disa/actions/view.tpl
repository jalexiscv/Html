<!-- Modal FullScreen {$mid} //-->
<div class="modal " id="{$mid}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Acción #{$action} del Plan #{$plan}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="disa-action">
                    <h2>Descripción</h2>
                    {$variables}
                    <h2>Implementación</h2>
                    {$implementation}
                    <h2>Evaluación</h2>
                    {$evaluation}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Continuar</button>
            </div>
        </div>
    </div>
</div>