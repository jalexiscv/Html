// Variables globales del mapa
let map;
let markers = [];
let geocoder;
let infoWindow;

// Variables para la línea de tiempo
let waypoints = [];
let timelineMarkers = [];
let pathPolyline = null;
let currentMarker = null;
let isPlaying = false;
let isPaused = false;
let currentIndex = 0;
let playbackInterval = null;
let playbackSpeed = 1;

// Configuración de la API
const API_BASE_URL = '/sogt/api/telemetry/';

// Inicializar el mapa
function initMap() {
    try {
        // Verificar que Google Maps API esté cargada
        if (typeof google === "undefined" || !google.maps) {
            console.error("Google Maps API no está cargada");
            return;
        }

        // Coordenadas por defecto (Bogotá, Colombia)
        const defaultLocation = {lat: 4.7110, lng: -74.0721};

        // Verificar que el elemento del mapa exista
        const mapElement = document.getElementById("map");
        if (!mapElement) {
            console.error("Elemento del mapa no encontrado");
            return;
        }

        // Crear el mapa
        map = new google.maps.Map(mapElement, {
            zoom: 10,
            center: defaultLocation,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: true,
            streetViewControl: true,
            fullscreenControl: true,
            zoomControl: true,
        });

        // Inicializar servicios
        geocoder = new google.maps.Geocoder();
        infoWindow = new google.maps.InfoWindow();

        // Cargar datos de waypoints desde la API
        loadWaypoints();

        // Event listener para clicks en el mapa
        if (map) {
            map.addListener("click", (event) => {
                const lat = event.latLng.lat();
                const lng = event.latLng.lng();

                // Actualizar campos de coordenadas
                document.getElementById("latitude").value = lat.toFixed(6);
                document.getElementById("longitude").value = lng.toFixed(6);

                // Agregar marcador
                addMarker(
                    {lat: lat, lng: lng},
                    "Ubicación seleccionada",
                    `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`
                );

                // Obtener información de la dirección
                getAddressFromCoordinates(lat, lng);
            });
        }

        // Inicializar event listeners
        initEventListeners();

    } catch (error) {
        console.error("Error inicializando el mapa:", error);
    }
}

// Cargar waypoints desde la API
async function loadWaypoints() {
    try {
        const response = await fetch(API_BASE_URL + 'json/');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        if (data.success && Array.isArray(data.data)) {
            waypoints = data.data;
            console.log("Waypoints cargados:", waypoints.length);

            if (waypoints.length > 0) {
                initTimeline();
            } else {
                console.log("No hay waypoints, agregando marcador por defecto");
                addMarker({lat: 4.7110, lng: -74.0721}, "Ubicación por defecto", "Bogotá, Colombia");
            }
        } else {
            console.warn("No se encontraron waypoints válidos");
            addMarker({lat: 4.7110, lng: -74.0721}, "Ubicación por defecto", "Bogotá, Colombia");
        }
    } catch (error) {
        console.error("Error cargando waypoints:", error);
        addMarker({lat: 4.7110, lng: -74.0721}, "Ubicación por defecto", "Bogotá, Colombia");
    }
}

// Agregar marcador al mapa
function addMarker(position, title, description) {
    const marker = new google.maps.Marker({
        position: position,
        map: map,
        title: title,
        animation: google.maps.Animation.DROP,
    });

    // Info window para el marcador
    const infoWindowContent = `
        <div class="info-window-content">
            <h6>${title}</h6>
            <p>${description}</p>
        </div>
    `;

    marker.addListener("click", () => {
        infoWindow.setContent(infoWindowContent);
        infoWindow.open(map, marker);
    });

    markers.push(marker);
    return marker;
}

// Buscar ubicación
function searchLocation() {
    const address = document.getElementById("searchInput").value;
    if (!address) {
        alert("Por favor ingrese una dirección para buscar");
        return;
    }

    geocoder.geocode({address: address}, (results, status) => {
        if (status === "OK" && results[0]) {
            const location = results[0].geometry.location;
            map.setCenter(location);
            map.setZoom(15);

            // Actualizar campos de coordenadas
            document.getElementById("latitude").value = location.lat().toFixed(6);
            document.getElementById("longitude").value = location.lng().toFixed(6);

            // Agregar marcador
            addMarker(
                {lat: location.lat(), lng: location.lng()},
                "Resultado de búsqueda",
                results[0].formatted_address
            );
        } else {
            alert("No se pudo encontrar la ubicación: " + status);
        }
    });
}

// Obtener ubicación actual
function getCurrentLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };

                map.setCenter(pos);
                map.setZoom(15);

                // Actualizar campos de coordenadas
                document.getElementById("latitude").value = pos.lat.toFixed(6);
                document.getElementById("longitude").value = pos.lng.toFixed(6);

                // Agregar marcador
                addMarker(pos, "Mi ubicación", "Ubicación actual del dispositivo");
            },
            () => {
                alert("Error: No se pudo obtener la ubicación");
            }
        );
    } else {
        alert("La geolocalización no es compatible con este navegador");
    }
}

// Cambiar tipo de mapa
function changeMapType(mapType) {
    map.setMapTypeId(mapType);
}

// Limpiar todos los marcadores
function clearMarkers() {
    markers.forEach(marker => {
        marker.setMap(null);
    });
    markers = [];

    // Limpiar marcadores de timeline
    timelineMarkers.forEach(marker => {
        marker.setMap(null);
    });
    timelineMarkers = [];

    // Limpiar polyline
    if (pathPolyline) {
        pathPolyline.setMap(null);
        pathPolyline = null;
    }

    // Limpiar marcador actual
    if (currentMarker) {
        currentMarker.setMap(null);
        currentMarker = null;
    }
}

// Obtener dirección desde coordenadas
function getAddressFromCoordinates(lat, lng) {
    const latlng = {lat: lat, lng: lng};
    geocoder.geocode({location: latlng}, (results, status) => {
        if (status === "OK" && results[0]) {
            console.log("Dirección encontrada:", results[0].formatted_address);
        }
    });
}

// Inicializar línea de tiempo
function initTimeline() {
    // Ordenar waypoints por timestamp
    waypoints.sort((a, b) => new Date(a.timestamp) - new Date(b.timestamp));

    // Configurar slider
    const slider = document.getElementById("timelineSlider");
    slider.max = waypoints.length - 1;
    slider.value = 0;

    // Mostrar información inicial
    updateTimelineInfo();

    // Crear trayectoria completa
    createFullPath();

    // Centrar mapa en el primer punto
    if (waypoints.length > 0) {
        const firstPoint = waypoints[0];
        map.setCenter({lat: parseFloat(firstPoint.lat), lng: parseFloat(firstPoint.lng)});
        map.setZoom(15);
    }

    // Crear marcador inicial
    updateCurrentPosition();
}

// Crear trayectoria completa
function createFullPath() {
    if (waypoints.length < 2) return;

    const path = waypoints.map(point => ({
        lat: parseFloat(point.lat),
        lng: parseFloat(point.lng)
    }));

    pathPolyline = new google.maps.Polyline({
        path: path,
        geodesic: true,
        strokeColor: "#FF0000",
        strokeOpacity: 0.6,
        strokeWeight: 3,
    });

    pathPolyline.setMap(map);
}

// Reproducir línea de tiempo
function playTimeline() {
    if (waypoints.length === 0) return;

    isPlaying = true;
    isPaused = false;
    updatePlaybackButtons();

    // Velocidad base: 1 punto por segundo
    const baseInterval = 1000;
    const interval = baseInterval / playbackSpeed;

    playbackInterval = setInterval(() => {
        if (currentIndex < waypoints.length - 1) {
            currentIndex++;
            updateCurrentPosition();
            updateSlider();
            updateTimelineInfo();
        } else {
            stopTimeline();
        }
    }, interval);
}

// Pausar línea de tiempo
function pauseTimeline() {
    if (playbackInterval) {
        clearInterval(playbackInterval);
        playbackInterval = null;
    }
    isPlaying = false;
    isPaused = true;
    updatePlaybackButtons();
}

// Detener línea de tiempo
function stopTimeline() {
    if (playbackInterval) {
        clearInterval(playbackInterval);
        playbackInterval = null;
    }
    isPlaying = false;
    isPaused = false;
    currentIndex = 0;
    updateCurrentPosition();
    updateSlider();
    updateTimelineInfo();
    updatePlaybackButtons();
}

// Actualizar botones de reproducción
function updatePlaybackButtons() {
    const playBtn = document.getElementById("playBtn");
    const pauseBtn = document.getElementById("pauseBtn");
    const stopBtn = document.getElementById("stopBtn");

    playBtn.disabled = isPlaying;
    pauseBtn.disabled = !isPlaying;
    stopBtn.disabled = !isPlaying && !isPaused;
}

// Actualizar posición actual
function updateCurrentPosition() {
    if (waypoints.length === 0) return;

    const currentWaypoint = waypoints[currentIndex];
    const position = {
        lat: parseFloat(currentWaypoint.lat),
        lng: parseFloat(currentWaypoint.lng)
    };

    // Remover marcador anterior
    if (currentMarker) {
        currentMarker.setMap(null);
    }

    // Crear nuevo marcador
    currentMarker = new google.maps.Marker({
        position: position,
        map: map,
        title: `Punto ${currentIndex + 1}`,
        icon: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 8,
            fillColor: "#4285F4",
            fillOpacity: 1,
            strokeColor: "#ffffff",
            strokeWeight: 2,
        },
        animation: google.maps.Animation.BOUNCE,
    });

    // Info window con información detallada
    const infoContent = `
        <div class="info-window-content">
            <h6>Punto ${currentIndex + 1} de ${waypoints.length}</h6>
            <p><strong>Dispositivo:</strong> ${currentWaypoint.device || 'N/A'}</p>
            <p><strong>Coordenadas:</strong> ${parseFloat(currentWaypoint.lat).toFixed(6)}, ${parseFloat(currentWaypoint.lng).toFixed(6)}</p>
            <p><strong>Velocidad:</strong> ${currentWaypoint.speed || 0} km/h</p>
            <p><strong>Altitud:</strong> ${currentWaypoint.alt || 0} m</p>
            <p><strong>Rumbo:</strong> ${currentWaypoint.heading || 0}°</p>
            <p><strong>Tiempo:</strong> ${formatTimestamp(currentWaypoint.timestamp)}</p>
        </div>
    `;

    currentMarker.addListener("click", () => {
        infoWindow.setContent(infoContent);
        infoWindow.open(map, currentMarker);
    });

    // Centrar mapa en el punto actual durante reproducción
    if (isPlaying) {
        map.setCenter(position);
    }

    // Detener animación después de un tiempo
    setTimeout(() => {
        if (currentMarker) {
            currentMarker.setAnimation(null);
        }
    }, 1000);
}

// Actualizar slider
function updateSlider() {
    const slider = document.getElementById("timelineSlider");
    slider.value = currentIndex;
}

// Actualizar información de línea de tiempo
function updateTimelineInfo() {
    if (waypoints.length === 0) return;

    const currentWaypoint = waypoints[currentIndex];

    // Actualizar información del punto actual
    document.getElementById("currentPoint").textContent = `${currentIndex + 1} / ${waypoints.length}`;
    document.getElementById("currentDevice").textContent = currentWaypoint.device || "--";
    document.getElementById("currentSpeed").textContent = `${currentWaypoint.speed || 0} km/h`;
    document.getElementById("currentAltitude").textContent = `${currentWaypoint.alt || 0} m`;
    document.getElementById("currentTime").textContent = formatTimestamp(currentWaypoint.timestamp);
}

// Formatear timestamp
function formatTimestamp(timestamp) {
    const date = new Date(timestamp);
    return date.toLocaleTimeString("es-ES", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit"
    });
}

// Inicializar event listeners
function initEventListeners() {
    // Controles de timeline
    document.getElementById("playBtn").addEventListener("click", playTimeline);
    document.getElementById("pauseBtn").addEventListener("click", pauseTimeline);
    document.getElementById("stopBtn").addEventListener("click", stopTimeline);

    // Control de velocidad
    document.getElementById("speedControl").addEventListener("change", (e) => {
        playbackSpeed = parseFloat(e.target.value);

        // Si está reproduciendo, reiniciar con nueva velocidad
        if (isPlaying) {
            pauseTimeline();
            playTimeline();
        }
    });

    // Slider de timeline
    document.getElementById("timelineSlider").addEventListener("input", (e) => {
        currentIndex = parseInt(e.target.value);
        updateCurrentPosition();
        updateTimelineInfo();
    });

    // Búsqueda
    document.getElementById("searchInput").addEventListener("keypress", (e) => {
        if (e.key === "Enter") {
            searchLocation();
        }
    });

    document.getElementById("searchBtn").addEventListener("click", searchLocation);
}

// Función de respaldo para inicializar el mapa
function initMapFallback() {
    console.log("Intentando inicialización de respaldo...");
    setTimeout(() => {
        if (typeof google !== "undefined" && google.maps) {
            initMap();
        } else {
            console.error("Google Maps API no se pudo cargar después del timeout");
        }
    }, 2000);
}

// Función global para manejar errores de Google Maps
window.gm_authFailure = function () {
    console.error("Error de autenticación de Google Maps API");
};

// Event listeners de inicialización
document.addEventListener("DOMContentLoaded", function () {
    // Verificar si Google Maps ya está disponible
    if (typeof google === "undefined" || !google.maps) {
        console.log("Google Maps API no está disponible aún, esperando...");
        initMapFallback();
    }
});
