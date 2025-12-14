<?php /** @var string $token  viene desde el head.css */?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        loadSidebarStates();
    });


    function toggleSidebar(id) {
        var element = document.getElementById(id);
        if (id === 'leftSidebar') {
            var isCollapsed = element.classList.contains('left-collapsed');
            if (isCollapsed) {
                element.classList.remove('d-none');
                element.classList.remove('left-collapsed');
                element.classList.add('left-expanded');
            } else {
                element.classList.add('d-none');
                element.classList.add('left-collapsed');
                element.classList.remove('left-expanded');
            }

        } else if (id === 'rightSidebar') {
            var isCollapsed = element.classList.contains('right-collapsed');
            if (isCollapsed) {
                element.classList.remove('d-none');
                element.classList.remove('right-collapsed');
                element.classList.add('right-expanded');
            } else {
                element.classList.add('d-none');
                element.classList.add('right-collapsed');
                element.classList.remove('right-expanded');
            }
        }
        localStorage.setItem(id, !isCollapsed);
        toggleSidebarState(id);
    }

    function loadSidebarStates() {
        var leftSidebarState = localStorage.getItem('leftSidebar');
        var rightSidebarState = localStorage.getItem('rightSidebar');

        if (leftSidebarState === 'true') {
            var eleft = document.getElementById('leftSidebar');
            eleft.classList.add('left-collapsed');
            eleft.classList.remove('left-expanded');
        }
        if (rightSidebarState === 'true') {
            var eright = document.getElementById('rightSidebar');
            eright.classList.add('right-collapsed');
            eright.classList.remove('right-expanded');
        }
    }


    function toggleSidebarState(id) {
        if (id === 'leftSidebar') {
            var state = document.getElementById(id).classList.contains('left-collapsed');
            var formData = new FormData();
            formData.append(id, (state ? "left-collapsed" : "left-expanded"));
            formData.append("javascript", true);
            fetch(window.location.href, {
                method: 'POST',
                body: formData
            });
        } else if (id === 'rightSidebar') {
            var state = document.getElementById(id).classList.contains('right-collapsed');
            var formData = new FormData();
            formData.append(id, (state ? "right-collapsed" : "right-expanded"));
            formData.append("javascript", true);
            fetch(window.location.href, {
                method: 'POST',
                body: formData
            });
        }
    }
    // Definir la función initGooglePlaces antes de cargar la API
    function initGooglePlaces() {
        // Código de inicialización para Google Places
        console.log("Google Places API inicializada correctamente");
        // Aquí puedes inicializar componentes como autocomplete, mapas, etc.
        // Ejemplo:
        // const input = document.getElementById('mi-ubicacion');
        // if (input) {
        //    const autocomplete = new google.maps.places.Autocomplete(input);
        // }
    }
    // Función para cargar la API de Google Maps según patrón recomendado
    function loadGoogleMapsScript() {
        const script = document.createElement('script');
        script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyApWZ9BWHUO8-HZrP5qla87kCEVEqix6YE&libraries=places&callback=initGooglePlaces";
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);
    }
    // Cargar Google Maps cuando la ventana termina de cargar
    if (window.addEventListener) {
        window.addEventListener('load', loadGoogleMapsScript, false);
    } else if (window.attachEvent) {
        window.attachEvent('onload', loadGoogleMapsScript);
    }

</script>
<script src="/themes/assets/libraries/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="/themes/assets/libraries/bootstrap/5.3.3/js/color-modes.js?v=<?php echo($token); ?>"></script>
<script src="/themes/assets/libraries/apexcharts/dist/apexcharts.js?v=<?php echo($token); ?>"></script>
<script type="module" src="/themes/assets/libraries/higgs/index.js?v=<?php echo($token); ?>"></script>



