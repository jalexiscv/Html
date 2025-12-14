<div class="modal fade" id="loadingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="loadingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <audio src="/themes/assets/audios/wait-momment-please-<?php echo(rand(1, 6));?>.mp3" id="audio-wait-momment"></audio>
                <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <h5 class="mb-2">Por favor espere</h5>
                <p class="mb-0">El procedimiento está en proceso...</p>
            </div>
        </div>
    </div>
</div>