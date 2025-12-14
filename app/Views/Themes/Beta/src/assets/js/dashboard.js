/**
 * Higgs Dashboard 2.1 - JavaScript
 * Funcionalidad para el dashboard moderno de Higgs
 */

document.addEventListener('DOMContentLoaded', function() {
    // Referencias a elementos del DOM
    // SQL Editor y elementos relacionados
    const sqlEditor = document.getElementById('sqlEditor');
    const runQueryBtn = document.getElementById('runQuery');
    const clearQueryBtn = document.getElementById('clearQuery');
    const saveQueryBtn = document.getElementById('saveQuery');
    const connectionSelector = document.getElementById('connectionSelector');
    const resultsContainer = document.getElementById('resultsContainer');
    const sqlLoader = document.getElementById('sqlLoader');
    
    // Botones de la interfaz
    const fullscreenBtn = document.getElementById('fullscreenBtn');
    const darkModeBtn = document.getElementById('darkModeBtn');
    const darkModeSetting = document.getElementById('darkModeSetting');
    
    // Elementos de sidebar y navegación
    const mainContent = document.getElementById('mainContent');
    
    // Legacy sidebar (sistema anterior)
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    
    // Sistema nuevo de sidebars (desktop)
    const toggleLeftSidebarBtn = document.getElementById('toggleLeftSidebar');
    const toggleRightSidebarBtn = document.getElementById('toggleRightSidebar');
    const leftSidebar = document.querySelector('.left-sidebar') || document.getElementById('leftSidebar');
    const rightSidebar = document.querySelector('.right-sidebar') || document.getElementById('rightSidebar');
    
    // Sistema para móviles
    const mobileOverlay = document.getElementById('mobileOverlay');
    const mobileToggleLeftBtn = document.getElementById('mobileToggleLeftSidebar');
    const mobileToggleRightBtn = document.getElementById('mobileToggleRightSidebar');
    const closeRightSidebarBtn = document.getElementById('closeRightSidebar');
    
    // ===============================
    // GESTIÓN DE SIDEBARS (DESKTOP)
    // ===============================
    
    // Sistema legacy (compatible con versiones anteriores)
    if (sidebarToggle && sidebar && mainContent) {
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            
            // Guardar estado en localStorage
            const sidebarCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebarCollapsed', sidebarCollapsed);
        });
        
        // Restaurar estado guardado
        const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (sidebarCollapsed) {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('expanded');
        }
    }
    
    // Sistema nuevo - sidebar izquierdo (desktop)
    // Esta función controla la visibilidad del sidebar izquierdo cuando se hace clic en el botón
    console.log('¿Existe botón toggle?', toggleLeftSidebarBtn ? 'Sí' : 'No');
    console.log('¿Existe sidebar izquierdo?', leftSidebar ? 'Sí' : 'No');
    
    // Implementación simplificada para asegurar el funcionamiento
    // Esta es nuestra implementación personalizada que sustituye la funcionalidad estándar
    if (toggleLeftSidebarBtn) {
        // Sobreescribimos directamente el atributo onclick del botón para mayor compatibilidad
        toggleLeftSidebarBtn.onclick = function(e) {
            // Cancelamos el comportamiento predeterminado
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            console.log('Botón toggleLeftSidebar clickeado - implementación directa');
            
            // Obtenemos una referencia directa al sidebar
            var sidebarElement = document.querySelector('.left-sidebar') || document.getElementById('leftSidebar');
            
            // Si no encontramos el sidebar, mostramos un error y salimos
            if (!sidebarElement) {
                console.error('Error: No se encontró el elemento sidebar');
                return false;
            }
            
            // Verificamos si el sidebar está colapsado
            var isCollapsed = sidebarElement.classList.contains('collapsed');
            
            // Invertimos el estado
            if (isCollapsed) {
                sidebarElement.classList.remove('collapsed');
                if (mainContent) mainContent.classList.remove('expanded-left');
                console.log('Sidebar expandido');
            } else {
                sidebarElement.classList.add('collapsed');
                if (mainContent) mainContent.classList.add('expanded-left');
                console.log('Sidebar colapsado');
            }
            
            // Actualizamos el estado en localStorage
            isCollapsed = !isCollapsed; // Ahora es el estado opuesto
            localStorage.setItem('leftSidebarCollapsed', isCollapsed);
            
            // Actualizamos el icono
            var icon = this.querySelector('i');
            if (icon) {
                if (isCollapsed) {
                    icon.className = ''; // Limpiamos clases existentes
                    icon.className = 'fas fa-angle-right';
                } else {
                    icon.className = ''; // Limpiamos clases existentes
                    icon.className = 'fas fa-bars';
                }
            }
            
            // Evitamos la propagación del evento
            return false;
        };
        
        // Aseguramos que el evento se active también al pulsar Enter cuando el botón tiene foco
        toggleLeftSidebarBtn.onkeydown = function(e) {
            if (e.key === 'Enter') {
                this.onclick();
            }
        };
        
        // Restaurar estado guardado
        const isLeftCollapsed = localStorage.getItem('leftSidebarCollapsed') === 'true';
        console.log('¿Estado guardado como colapsado?', isLeftCollapsed ? 'Sí' : 'No');
        
        // Si no encontramos el sidebar con la primera selección, intentamos de nuevo
        const sidebarElement = leftSidebar || document.querySelector('.left-sidebar') || document.getElementById('leftSidebar');
        
        if (isLeftCollapsed && sidebarElement) {
            sidebarElement.classList.add('collapsed');
            console.log('Sidebar colapsado al iniciar');
            
            if (mainContent) {
                mainContent.classList.add('expanded-left');
            }
            
            const icon = toggleLeftSidebarBtn.querySelector('i');
            if (icon) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-angle-right');
                console.log('Icono actualizado al iniciar');
            } else {
                console.warn('No se encontró el icono al iniciar');
            }
        }
    }

    
    // Sistema nuevo - sidebar derecho (desktop)
    if (toggleRightSidebarBtn && rightSidebar) {
        toggleRightSidebarBtn.addEventListener('click', function() {
            rightSidebar.classList.toggle('collapsed');
            if (mainContent) {
                mainContent.classList.toggle('expanded-right');
            }
            
            // Guardar estado en localStorage
            const isCollapsed = rightSidebar.classList.contains('collapsed');
            localStorage.setItem('rightSidebarCollapsed', isCollapsed);
            
            // Actualizar icono
            const icon = this.querySelector('i');
            if (icon) {
                if (isCollapsed) {
                    icon.classList.remove('fa-arrow-right');
                    icon.classList.add('fa-angle-left');
                } else {
                    icon.classList.remove('fa-angle-left');
                    icon.classList.add('fa-arrow-right');
                }
            }
        });
        
        // Restaurar estado guardado
        const isRightCollapsed = localStorage.getItem('rightSidebarCollapsed') === 'true';
        if (isRightCollapsed && rightSidebar) {
            rightSidebar.classList.add('collapsed');
            if (mainContent) {
                mainContent.classList.add('expanded-right');
            }
            const icon = toggleRightSidebarBtn.querySelector('i');
            if (icon) {
                icon.classList.remove('fa-arrow-right');
                icon.classList.add('fa-angle-left');
            }
        }
    }
    
    // Manejar la ejecución de consultas SQL
    if (runQueryBtn && sqlEditor) {
        runQueryBtn.addEventListener('click', function() {
            const query = sqlEditor.value.trim();
            if (!query) {
                showNotification('Por favor, escribe una consulta SQL', 'warning');
                return;
            }
            
            const connectionId = connectionSelector ? connectionSelector.value : null;
            if (!connectionId) {
                showNotification('Selecciona una conexión primero', 'warning');
                return;
            }
            
            // Mostrar loader
            if (sqlLoader) sqlLoader.classList.add('active');
            
            // Simular la ejecución de la consulta
            setTimeout(function() {
                // Ocultar loader
                if (sqlLoader) sqlLoader.classList.remove('active');
                
                // Mostrar resultados (esto sería reemplazado por los resultados reales de la API)
                if (resultsContainer) {
                    // Detectar el tipo de consulta para mostrar resultados diferentes
                    if (query.toLowerCase().startsWith('select')) {
                        showSelectResults(resultsContainer);
                    } else if (query.toLowerCase().startsWith('insert') || 
                               query.toLowerCase().startsWith('update') || 
                               query.toLowerCase().startsWith('delete')) {
                        showExecutionResults(resultsContainer);
                    } else {
                        showGenericResults(resultsContainer);
                    }
                }
                
                // Guardar la consulta en el historial
                saveToHistory(query);
                
                showNotification('Consulta ejecutada con éxito', 'success');
            }, 1500);
        });
    }
    
    // Limpiar editor SQL
    if (clearQueryBtn && sqlEditor) {
        clearQueryBtn.addEventListener('click', function() {
            sqlEditor.value = '';
            sqlEditor.focus();
        });
    }
    
    // Cambiar el estado de los botones según la selección de conexión
    if (connectionSelector) {
        connectionSelector.addEventListener('change', function() {
            const isConnectionSelected = this.value !== '';
            
            if (runQueryBtn) runQueryBtn.disabled = !isConnectionSelected;
            if (saveQueryBtn) saveQueryBtn.disabled = !isConnectionSelected;
            
            if (sqlEditor) {
                if (isConnectionSelected) {
                    sqlEditor.placeholder = "SELECT * FROM tabla WHERE condicion;";
                    sqlEditor.disabled = false;
                } else {
                    sqlEditor.placeholder = "Selecciona una conexión primero...";
                    sqlEditor.disabled = true;
                }
            }
        });
        
        // Disparar el evento change para establecer el estado inicial
        connectionSelector.dispatchEvent(new Event('change'));
    }
    
    // Guardar consulta (simulado)
    if (saveQueryBtn) {
        saveQueryBtn.addEventListener('click', function() {
            const query = sqlEditor.value.trim();
            if (!query) {
                showNotification('No hay consulta para guardar', 'warning');
                return;
            }
            
            // Aquí iría la lógica para guardar la consulta
            
            showNotification('Consulta guardada correctamente', 'success');
        });
    }
    
    // Función para mostrar notificaciones
    function showNotification(message, type) {
        const notificationArea = document.querySelector('.notification-area');
        if (!notificationArea) return;
        
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show`;
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        `;
        
        notificationArea.appendChild(notification);
        
        // Auto-cerrar después de 5 segundos
        setTimeout(function() {
            notification.classList.remove('show');
            setTimeout(function() {
                notification.remove();
            }, 150);
        }, 5000);
    }
    
    // Función para guardar en el historial (simulado)
    function saveToHistory(query) {
        const historyList = document.getElementById('queryHistory');
        if (!historyList) return;
        
        const historyItem = document.createElement('a');
        historyItem.className = 'list-group-item list-group-item-action';
        historyItem.href = '#';
        
        // Truncar la consulta si es muy larga
        const truncatedQuery = query.length > 50 ? query.substring(0, 47) + '...' : query;
        
        historyItem.innerHTML = `
            <div class="d-flex w-100 justify-content-between">
                <p class="mb-1">${truncatedQuery}</p>
                <small>${new Date().toLocaleTimeString()}</small>
            </div>
        `;
        
        // Agregar al principio de la lista
        historyList.insertBefore(historyItem, historyList.firstChild);
        
        // Limitar a 10 elementos
        if (historyList.children.length > 10) {
            historyList.removeChild(historyList.lastChild);
        }
        
        // Hacer que el elemento sea clickeable para cargar la consulta
        historyItem.addEventListener('click', function(e) {
            e.preventDefault();
            sqlEditor.value = query;
            sqlEditor.focus();
        });
    }
    
    // Función para mostrar resultados de SELECT (simulado)
    function showSelectResults(container) {
        container.innerHTML = `
            <div class="table-responsive">
                <table class="results-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Producto A</td>
                            <td>Electrónica</td>
                            <td>$599.99</td>
                            <td>45</td>
                            <td>2025-03-15</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Producto B</td>
                            <td>Hogar</td>
                            <td>$129.50</td>
                            <td>12</td>
                            <td>2025-04-22</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Producto C</td>
                            <td>Electrónica</td>
                            <td>$899.99</td>
                            <td>8</td>
                            <td>2025-05-10</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Producto D</td>
                            <td>Ropa</td>
                            <td>$49.99</td>
                            <td>120</td>
                            <td>2025-02-28</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Producto E</td>
                            <td>Alimentos</td>
                            <td>$12.75</td>
                            <td>85</td>
                            <td>2025-05-20</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <p class="text-muted">5 filas devueltas. Tiempo de ejecución: 0.023s</p>
            </div>
        `;
    }
    
    // Función para mostrar resultados de INSERT/UPDATE/DELETE (simulado)
    function showExecutionResults(container) {
        container.innerHTML = `
            <div class="alert alert-success">
                <h4 class="alert-heading">Operación completada</h4>
                <p>La operación se ha ejecutado correctamente.</p>
                <hr>
                <p class="mb-0">Filas afectadas: 3</p>
                <p class="mb-0">Tiempo de ejecución: 0.035s</p>
            </div>
        `;
    }
    
    // Función para mostrar resultados genéricos (simulado)
    function showGenericResults(container) {
        container.innerHTML = `
            <div class="alert alert-info">
                <h4 class="alert-heading">Consulta ejecutada</h4>
                <p>La consulta se ha ejecutado correctamente.</p>
                <hr>
                <p class="mb-0">Tiempo de ejecución: 0.018s</p>
            </div>
        `;
    }
    
    // ===============================
    // GESTIÓN DE SIDEBARS (MÓVIL)
    // ===============================
    
    // Funciones para sidebars en móvil
    function toggleMobileLeftSidebar() {
        if (leftSidebar) {
            const isOpen = leftSidebar.classList.contains('show');
            // Cerrar sidebar derecho si está abierto
            if (rightSidebar) rightSidebar.classList.remove('show');
            // Toggle sidebar izquierdo
            leftSidebar.classList.toggle('show');
            if (mobileOverlay) mobileOverlay.classList.toggle('show', !isOpen);
        }
    }
    
    function toggleMobileRightSidebar() {
        if (rightSidebar) {
            const isOpen = rightSidebar.classList.contains('show');
            // Cerrar sidebar izquierdo si está abierto
            if (leftSidebar) leftSidebar.classList.remove('show');
            // Toggle sidebar derecho
            rightSidebar.classList.toggle('show');
            if (mobileOverlay) mobileOverlay.classList.toggle('show', !isOpen);
        }
    }
    
    // Configurar controles para móvil
    if (mobileToggleLeftBtn) {
        mobileToggleLeftBtn.addEventListener('click', toggleMobileLeftSidebar);
    }
    
    if (mobileToggleRightBtn) {
        mobileToggleRightBtn.addEventListener('click', toggleMobileRightSidebar);
    }
    
    if (closeRightSidebarBtn) {
        closeRightSidebarBtn.addEventListener('click', toggleMobileRightSidebar);
    }
    
    // Responsive: ocultar sidebars móviles en desktop
    function checkScreenSize() {
        if (window.innerWidth >= 768) {
            if (leftSidebar) leftSidebar.classList.remove('show');
            if (rightSidebar) rightSidebar.classList.remove('show');
            if (mobileOverlay) mobileOverlay.classList.remove('show');
        }
    }
    
    // Inicializar responsive
    checkScreenSize();
    window.addEventListener('resize', checkScreenSize);
    
    // Cerrar sidebars al hacer clic en el overlay
    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', function() {
            if (leftSidebar) leftSidebar.classList.remove('show');
            if (rightSidebar) rightSidebar.classList.remove('show');
            mobileOverlay.classList.remove('show');
        });
    }
    
    // Soporte para gestos táctiles en móvil
    let touchStartX = 0;
    let touchEndX = 0;
    
    document.addEventListener('touchstart', function(event) {
        touchStartX = event.changedTouches[0].screenX;
    }, false);
    
    document.addEventListener('touchend', function(event) {
        touchEndX = event.changedTouches[0].screenX;
        handleSwipe();
    }, false);
    
    function handleSwipe() {
        const swipeDistance = touchEndX - touchStartX;
        const threshold = 100; // Distancia mínima para considerar un swipe
        
        if (swipeDistance > threshold && leftSidebar) {
            // Swipe de izquierda a derecha: abrir sidebar izquierdo
            leftSidebar.classList.add('show');
            if (rightSidebar) rightSidebar.classList.remove('show');
            if (mobileOverlay) mobileOverlay.classList.add('show');
        } else if (swipeDistance < -threshold && rightSidebar) {
            // Swipe de derecha a izquierda: abrir sidebar derecho
            rightSidebar.classList.add('show');
            if (leftSidebar) leftSidebar.classList.remove('show');
            if (mobileOverlay) mobileOverlay.classList.add('show');
        }
    }
    
    // ===============================
    // GESTIÓN DE GRÁFICOS
    // ===============================
    
    // Inicialización del gráfico de balance (ingresos vs gastos)
    function initBalanceChart() {
        const balanceChart = document.getElementById('balanceChart');
        if (!balanceChart) return;
        
        const balanceData = {
            labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
            datasets: [
                {
                    label: 'Ingresos',
                    data: [320, 280, 300, 340, 360, 300, 380],
                    backgroundColor: 'rgba(76, 110, 245, 0.1)',
                    borderColor: 'rgba(76, 110, 245, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(76, 110, 245, 1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Gastos',
                    data: [220, 180, 260, 190, 280, 140, 200],
                    backgroundColor: 'rgba(245, 60, 86, 0.1)',
                    borderColor: 'rgba(245, 60, 86, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(245, 60, 86, 1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        };

        const balanceConfig = {
            type: 'line',
            data: balanceData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            boxWidth: 10,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#5C6B8B',
                        bodyColor: '#5C6B8B',
                        borderColor: '#E0E6ED',
                        borderWidth: 1,
                        padding: 10,
                        cornerRadius: 8,
                        boxPadding: 4,
                        usePointStyle: true,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': $' + context.raw;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(224, 230, 237, 0.5)'
                        },
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    }
                }
            }
        };
        
        new Chart(balanceChart, balanceConfig);
    }
    
    // Inicialización del gráfico de distribución de gastos
    function initExpenseChart() {
        const expenseChart = document.getElementById('expenseChart');
        if (!expenseChart) return;
        
        const expenseData = {
            labels: ['Alimentación', 'Vivienda', 'Transporte', 'Entretenimiento', 'Otros'],
            datasets: [{
                data: [35, 25, 15, 10, 15],
                backgroundColor: [
                    '#4c6ef8',
                    '#f53c56',
                    '#36b9cc',
                    '#f6c23e',
                    '#858796'
                ],
                borderWidth: 0,
                hoverOffset: 5
            }]
        };
        
        const expenseConfig = {
            type: 'doughnut',
            data: expenseData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 10,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed + '%';
                            }
                        }
                    }
                },
                cutout: '75%'
            }
        };
        
        new Chart(expenseChart, expenseConfig);
    }
    
    // Inicializar gráficos si existen sus contenedores
    initBalanceChart();
    initExpenseChart();
    
    // Funcionalidad para el botón de pantalla completa
    if (fullscreenBtn) {
        fullscreenBtn.addEventListener('click', function() {
            if (!document.fullscreenElement) {
                // Entrar en modo pantalla completa
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.webkitRequestFullscreen) { /* Safari */
                    document.documentElement.webkitRequestFullscreen();
                } else if (document.documentElement.msRequestFullscreen) { /* IE11 */
                    document.documentElement.msRequestFullscreen();
                }
                fullscreenBtn.querySelector('i').classList.remove('fa-expand');
                fullscreenBtn.querySelector('i').classList.add('fa-compress');
            } else {
                // Salir del modo pantalla completa
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.webkitExitFullscreen) { /* Safari */
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) { /* IE11 */
                    document.msExitFullscreen();
                }
                fullscreenBtn.querySelector('i').classList.remove('fa-compress');
                fullscreenBtn.querySelector('i').classList.add('fa-expand');
            }
        });
        
        // Detectar cambios en el estado de pantalla completa
        document.addEventListener('fullscreenchange', function() {
            if (!document.fullscreenElement) {
                fullscreenBtn.querySelector('i').classList.remove('fa-compress');
                fullscreenBtn.querySelector('i').classList.add('fa-expand');
            }
        });
    }
    

    
    // Inicializar tooltips de Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
