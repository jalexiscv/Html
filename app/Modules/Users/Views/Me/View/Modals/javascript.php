<script>
    // Función para mostrar el modal
    function showLoading() {
        const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
        loadingModal.show();
        const audio = document.getElementById('audio-wait-momment');
        audio.play();
        audio.addEventListener('ended', function() {
            hideLoading();
            location.reload();
        });
    }

    // Función para ocultar el modal
    function hideLoading() {
        const loadingModal = bootstrap.Modal.getInstance(document.getElementById('loadingModal'));
        if (loadingModal) {
            loadingModal.hide();
        }
    }

</script>