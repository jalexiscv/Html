<script>
    function adjustViewport() {
        const width = window.innerWidth;
        // Detecta si el ancho es menor o igual a 1380px (u otros tamaños habituales)
        if (width <= 1380) {
            document.querySelector('meta[name="viewport"]').setAttribute('content', 'width=device-width, initial-scale=0.9');
        } else if (width <= 1024) {
            document.querySelector('meta[name="viewport"]').setAttribute('content', 'width=device-width, initial-scale=0.8');
        } else {
            document.querySelector('meta[name="viewport"]').setAttribute('content', 'width=device-width, initial-scale=1.0');
        }
    }

    // Ejecuta la función cuando la página se carga y cada vez que la ventana se redimensiona
    window.onload = adjustViewport;
    //window.onresize = adjustViewport;
</script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>